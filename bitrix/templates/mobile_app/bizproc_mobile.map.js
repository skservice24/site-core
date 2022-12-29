{"version":3,"sources":["bizproc_mobile.js"],"names":["BX","BizProcMobile","doTask","parameters","callback","silent","preparePost","FormData","append","bitrix_sessid","app","showPopupLoader","text","url","message","ajax","method","dataType","data","onsuccess","json","hidePopupLoader","ERROR","alert","title","BXMobileApp","onCustomEvent","onfailure","e","console","error","openTaskPage","taskId","event","target","tagName","toLowerCase","anchorNode","findParent","tag","className","hasClass","loadPageBlank","unique","renderLogMessage","logElement","newContent","updateId","wrapper","parentNode","innerHTML","querySelector","tasks","JSON","parse","getAttribute","userId","statusWaiting","statusYes","statusNo","statusOk","statusCancel","userStatus","getUserFromTask","task","i","l","USERS","length","user","STATUS","ID","btn","findChild","style","display","taskBlock","userStatusCls","userStatusBlock","statusBlock","setAttribute","renderLogMessages","scope","workflowId","newLogContent","items","querySelectorAll","rendered","itemWorkflowId","toString","itemContent","loadLogMessageCallback","WORKFLOW_ID","HTML","parseInt","Math","random","document","renderFacePhoto","users","displayedUser","onload","src","showDatePicker","format","input","type","pickerParams","value","d","Date","siteFormat","formatted","formatDate","UI","DatePicker","setParams","show","PreventDefault"],"mappings":"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","file":"bizproc_mobile.map.js"}