function CompactTitleSearch(arParams) {
	var _this = this;

	this.arParams = {
		'AJAX_PAGE': arParams.AJAX_PAGE,
		'CONTAINER_ID': arParams.CONTAINER_ID,
		'INPUT_ID': arParams.INPUT_ID,
		'MIN_QUERY_LEN': parseInt(arParams.MIN_QUERY_LEN)
	};
	if (arParams.WAIT_IMAGE)
		this.arParams.WAIT_IMAGE = arParams.WAIT_IMAGE;
	if (arParams.MIN_QUERY_LEN <= 0)
		arParams.MIN_QUERY_LEN = 1;

	this.cache = [];
	this.cache_key = null;

	this.startText = '';
	this.running = false;
	this.currentRow = -1;
	this.RESULT = null;
	this.CONTAINER = null;
	this.INPUT = null;
	this.WAIT = null;

	this.ShowResult = function(result) {
		if (BX.type.isString(result)) {
			_this.RESULT.innerHTML = result;
		}

		if ($(_this.CONTAINER).is(':hidden') || !$(_this.INPUT).is(':focus')) {
			return;
		}

		_this.RESULT.style.display = _this.RESULT.innerHTML !== '' ? 'block' : 'none';
		var pos = _this.adjustResultNode();
	};

	this.onKeyPress = function(keyCode) {
	};

	this.onChange = function(callback) {
		if (_this.running)
			return;
		_this.running = true;

		if (_this.INPUT.value != _this.oldValue && _this.INPUT.value != _this.startText) {
			_this.oldValue = _this.INPUT.value;
			if (_this.INPUT.value.length >= _this.arParams.MIN_QUERY_LEN) {
				_this.cache_key = _this.arParams.INPUT_ID + '|' + _this.INPUT.value;
				if (_this.cache[_this.cache_key] == null) {
					if (_this.WAIT) {
						var pos = BX.pos(_this.INPUT);
						var height = (pos.bottom - pos.top) - 2;
						_this.WAIT.style.top = (pos.top + 1) + 'px';
						_this.WAIT.style.height = height + 'px';
						_this.WAIT.style.width = height + 'px';
						_this.WAIT.style.left = (pos.right - height + 2) + 'px';
						_this.WAIT.style.display = 'block';
					}

					BX.ajax.post(
						_this.arParams.AJAX_PAGE, {
							'ajax_call': 'y',
							'INPUT_ID': _this.arParams.INPUT_ID,
							'q': _this.INPUT.value,
							'l': _this.arParams.MIN_QUERY_LEN
						},
						function(result) {
							_this.cache[_this.cache_key] = result;
							_this.ShowResult(result);
							_this.currentRow = -1;
							_this.EnableMouseEvents();
							if (_this.WAIT)
								_this.WAIT.style.display = 'none';
							if (!!callback)
								callback();
							_this.running = false;
						}
					);
					return;
				} else {
					_this.ShowResult(_this.cache[_this.cache_key]);
					_this.currentRow = -1;
					_this.EnableMouseEvents();
				}
			} else {
				_this.RESULT.style.display = 'none';
				_this.currentRow = -1;
				_this.UnSelectAll();
			}
		}
		if (!!callback)
			callback();
		_this.running = false;
	};

	this.onScroll = function() {
		if (BX.type.isElementNode(_this.RESULT) &&
			_this.RESULT.style.display !== "none" &&
			_this.RESULT.innerHTML !== ''
		) {
			_this.adjustResultNode();
		}
	};

	this.UnSelectAll = function() {};

	this.EnableMouseEvents = function() {	};

	this.onFocusLost = function(hide) {
		setTimeout(function() {
			_this.RESULT.style.display = 'none';
		}, 250);
	};

	this.onFocusGain = function() {
		if (_this.RESULT.innerHTML.length)
			_this.ShowResult();
	};

	this.onKeyDown = function(e) {
		if (!e)
			e = window.event;

		if (_this.RESULT.style.display == 'block') {
			if (_this.onKeyPress(e.keyCode))
				return BX.PreventDefault(e);
		}
	};

	this.adjustResultNode = function() {
		if (!(BX.type.isElementNode(_this.RESULT) &&
				BX.type.isElementNode(_this.CONTAINER))) {
			return {
				top: 0,
				right: 0,
				bottom: 0,
				left: 0,
				width: 0,
				height: 0
			};
		}

		var pos = BX.pos(_this.CONTAINER);

		_this.RESULT.style.position = 'absolute';
		_this.RESULT.style.top = (pos.bottom + 2) + 'px';
		_this.RESULT.style.left = pos.left + 'px';
		_this.RESULT.style.width = pos.width + 'px';
		_this.RESULT.style.overflowY = "auto";
		_this.RESULT.style.maxHeight = ($(window).outerHeight() - pos.height) + 'px';

		return pos;
	};

	this._onContainerLayoutChange = function() {
		if (BX.type.isElementNode(_this.RESULT) &&
			_this.RESULT.style.display !== "none" &&
			_this.RESULT.innerHTML !== ''
		) {
			_this.adjustResultNode();
		}
	};
	this.Init = function() {
		this.CONTAINER = document.getElementById(this.arParams.CONTAINER_ID);
		BX.addCustomEvent(this.CONTAINER, "OnNodeLayoutChange", this._onContainerLayoutChange);

		this.RESULT = document.body.appendChild(document.createElement("DIV"));
		this.RESULT.className = 'title-search-result';
		this.INPUT = document.getElementById(this.arParams.INPUT_ID);
		this.startText = this.oldValue = this.INPUT.value;
		BX.bind(this.INPUT, 'focus', function() {
			_this.onFocusGain()
		});
		BX.bind(this.INPUT, 'blur', function() {
			_this.onFocusLost()
		});
		this.INPUT.onkeydown = this.onKeyDown;

		if (this.arParams.WAIT_IMAGE) {
			this.WAIT = document.body.appendChild(document.createElement("DIV"));
			this.WAIT.style.backgroundImage = "url('" + this.arParams.WAIT_IMAGE + "')";
			if (!BX.browser.IsIE())
				this.WAIT.style.backgroundRepeat = 'none';
			this.WAIT.style.display = 'none';
			this.WAIT.style.position = 'absolute';
			this.WAIT.style.zIndex = '1100';
		}

		BX.bind(this.INPUT, 'bxchange', function() {
			_this.onChange()
		});

		if (RS.Options.fixingCompactHeader) {
			BX.bind(window, 'scroll', BX.proxy(this.onScroll, this));

			$(RS.Options.compactHeaderSelector).on('unfixed.compact-header', function() {
				if (RS.Utils.isDesktop()) {
					_this.onFocusLost();
				}
			});

		}
	};
	BX.ready(function() {
		_this.Init(arParams)
	});
}
