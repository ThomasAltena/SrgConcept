<script>
function DataRequest (manager, method, originalObject, args, doNotJSONReturn) {
  var request = new XMLHttpRequest();
  return new Promise(function (resolve, reject) {
    request.onreadystatechange = function () {
      if (request.readyState !== 4) return;
      if (request.status >= 200 && request.status < 300) {
        //return this.responseText;
        resolve(request);
      } else {
        reject({
          status: request.status,
          statusText: request.statusText
        });
      }
    };
    let getoriginalObject = originalObject ? "&originalObject=true" : "";
    let DoNotJSON = doNotJSONReturn ? "&DoNotJSON=true" : "";
    request.open("POST", "/SrgConcept/ServiceHelper.php?manager=" + manager + "&route=" + method + getoriginalObject + DoNotJSON, true);
    request.send(args != undefined ? JSON.stringify(args) : null);
  });
}

function ViewRequest (url) {
  var request = new XMLHttpRequest();
  return new Promise(function (resolve, reject) {
    request.onreadystatechange = function () {
      if (request.readyState !== 4) return;
      if (request.status >= 200 && request.status < 300) {
        //return this.responseText;
        resolve(request);
      } else {
        reject({
          status: request.status,
          statusText: request.statusText
        });
      }
    };
    request.open("POST", url, true);
    request.send();
  });
}
</script>
