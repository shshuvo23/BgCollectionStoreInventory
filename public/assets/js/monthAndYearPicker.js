var monthYearOnlyElements = [];

      document.addEventListener("DOMContentLoaded", () => {
        monthYearOnlyElements = document.querySelectorAll('input[type="monthYearOnly"]');

        for(var monthYearOnlyElementDx=0; monthYearOnlyElementDx<monthYearOnlyElements.length; monthYearOnlyElementDx++){

          var monthYearOnlyInputDialogEle = document.createElement('div');
          monthYearOnlyInputDialogEle.id = "monthYearOnlyInputDialog"+monthYearOnlyElementDx;
          monthYearOnlyInputDialogEle.style.boxShadow = "5px 5px 20px 5px #aaaaaa";
          monthYearOnlyInputDialogEle.style.position = "absolute";
          monthYearOnlyInputDialogEle.style.display = "none";

          var innerHtmls = "" +
                          "<div style=\" margin: 5px;padding: 10px;\">" +
                          "              <select id=\"monthYearOnlyDateDialog"+monthYearOnlyElementDx+"\" style=\"margin-bottom: 10px;\">" +
                          "                " +
                          "              </select>" +
                          "              <div>" +
                          "                <table style=\"width: 100%;\">" +
                          "                  <tr>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('January', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Jan</button></td>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('February', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Feb</button></td>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('March', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Mar</button></td>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('April', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Apr</button></td>" +
                          "                  </tr>" +
                          "                  <tr>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('May', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">May</button></td>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('June', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Jun</button></td>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('July', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Jul</button></td>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('August', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Aug</button></td>" +
                          "                  </tr>" +
                          "                  <tr>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('September', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Sep</button></td>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('October', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Oct</button></td>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('November', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Nov</button></td>" +
                          "                    <td><button type=\"button\" onclick=\"monthYearOnlySetDate('December', "+monthYearOnlyElementDx+")\" style=\"height: 100%; width: 100%; border: none;\">Dec</button></td>" +
                          "                  </tr>" +
                          "                </table>" +
                          "              </div>" +
                          "            </div>" +
                          "";

          var monthYearOnlyInputDialogOffSetLeft = monthYearOnlyElements[monthYearOnlyElementDx].offsetLeft - monthYearOnlyElements[monthYearOnlyElementDx].parentNode.offsetLeft;
          var monthYearOnlyInputDialogOffSetBottom = monthYearOnlyElements[monthYearOnlyElementDx].marginBottom;

        //   monthYearOnlyInputDialogEle.style.marginLeft = monthYearOnlyInputDialogOffSetLeft+"px";
          monthYearOnlyInputDialogEle.style.marginLeft = getComputedStyle(monthYearOnlyElements[monthYearOnlyElementDx])['margin-left'];
          monthYearOnlyInputDialogEle.style.marginTop = "-"+getComputedStyle(monthYearOnlyElements[monthYearOnlyElementDx])['margin-bottom'];
          monthYearOnlyInputDialogEle.style.backgroundColor = "#fff";
          monthYearOnlyInputDialogEle.style.zIndex = 10000000;

          monthYearOnlyInputDialogEle.innerHTML = innerHtmls;

          monthYearOnlyElements[monthYearOnlyElementDx].parentNode.insertBefore(monthYearOnlyInputDialogEle, monthYearOnlyElements[monthYearOnlyElementDx].nextSibling);


          monthYearOnlyElements[monthYearOnlyElementDx].readOnly = true;
          monthYearOnlyElements[monthYearOnlyElementDx].style.cursor = "pointer";
          monthYearOnlyElements[monthYearOnlyElementDx].placeholder = "MM-YYYY";
          monthYearOnlyElements[monthYearOnlyElementDx].setAttribute('onclick', "monthYearOnlyDialogOpenClose("+monthYearOnlyElementDx+")");
        }
      });



      function monthYearOnlyDialogOpenClose(monthYearOnlyDx){
          var monthYearOnlyDialog = document.getElementById("monthYearOnlyInputDialog"+monthYearOnlyDx);
          if(monthYearOnlyDialog.style.display == "none"){
            monthYearOnlyDialog.style.display = "";
            monthYearOnlyDateDialog(monthYearOnlyDx);
          }
          else monthYearOnlyDialog.style.display = "none";
      }

      function monthYearOnlyDateDialog(monthYearOnlyDx){
        var monthYearOnlyCurrentTime = new Date();
        var monthYearOnlyCurrentYear = monthYearOnlyCurrentTime.getFullYear();
        var monthYearOnlyYearOptions = "";
        for(var monthYearOnlyYearIteration=monthYearOnlyCurrentYear-2; monthYearOnlyYearIteration<=monthYearOnlyCurrentYear+20; monthYearOnlyYearIteration++){
          if(monthYearOnlyYearIteration==monthYearOnlyCurrentYear)
          monthYearOnlyYearOptions += "<option value='"+monthYearOnlyYearIteration+"' selected>"+monthYearOnlyYearIteration+"</option>";
          else monthYearOnlyYearOptions += "<option value='"+monthYearOnlyYearIteration+"'>"+monthYearOnlyYearIteration+"</option>";
        }
        document.getElementById("monthYearOnlyDateDialog"+monthYearOnlyDx).innerHTML = monthYearOnlyYearOptions;
      }

      function monthYearOnlySetDate(monthYearOnlyMonth, monthYearOnlyDx){
        var monthYearOnlyYear = document.getElementById("monthYearOnlyDateDialog"+monthYearOnlyDx).value;
        var monthYearOnlyDate = monthYearOnlyMonth+"-"+monthYearOnlyYear;
        monthYearOnlyElements[monthYearOnlyDx].value = monthYearOnlyDate;
        monthYearOnlyDialogOpenClose(monthYearOnlyDx);

      }
