window.onload = ()=>{
    var body = document.querySelector('body');

    window.addEventListener("resize", ()=>{
        adjustnav();
    })

    

}

function openDropdown(num){
    
    var dropdownitem = document.querySelectorAll(".dropdown-container");
    
    var endofplay = false;
    // var dropdownlink = dropdownitem[num].children;
    // var dropdownlink = dropdownitem[num].lastChild;
    var dropdownlink = dropdownitem[num].lastElementChild;

    var dropdownlinkcont = dropdownlink.children;

    dropdownlink.style.transition = "1s ease all";

    if(dropdownlink.style.maxHeight !== "300px"){

        dropdownlink.style.maxHeight = "300px";

        for(var i = 0; i < dropdownlinkcont.length;  i++){
            dropdownlinkcont[i].style.animationName = "fadein";
            dropdownlinkcont[i].style.animationDelay = i * 0.3 + "s";

        }

        dropdownlinkcont[dropdownlinkcont.length - 1].addEventListener('animationend', animationended)

        function animationended(){
            endofplay = true;
            if(endofplay){
    
                for(var i = 0; i < dropdownlinkcont.length;  i++){
                    dropdownlinkcont[i].style.opacity = "1";
        
                }
    
                endofplay = false;
                dropdownlinkcont[dropdownlinkcont.length - 1].removeEventListener('animationend', animationended)
    
            }
        }


        
    }else{
        var dropdownlinkcontreverse = [];
        var delay = 0;

        for(var i = eval(dropdownlinkcont.length - 1); i >= 0; i-- ){
            dropdownlinkcontreverse.push(dropdownlinkcont[i]);
        }

        for(var i = 0; i < dropdownlinkcontreverse.length;  i++){
            dropdownlinkcontreverse[i].style.animationName = "fadeout";
            dropdownlinkcontreverse[i].style.animationDelay = i * 0.3 + "s";

        }

        dropdownlinkcontreverse[dropdownlinkcontreverse.length - 1].addEventListener('animationend', animationended)

        function animationended(){
            endofplay = true;
            if(endofplay){
    
                for(var i = 0; i < dropdownlinkcontreverse.length;  i++){
                    dropdownlinkcont[i].style.opacity = "0";
        
                }
    
                endofplay = false;
                dropdownlinkcontreverse[dropdownlinkcontreverse.length - 1].removeEventListener('animationend', animationended)
    
                dropdownlink.style.maxHeight = "0px";
            }
        }


        // console.log(dropdownlinkcontreverse);
    }


    // console.log(dropdownlinkcont);
}

function showFilterLink(){
    var filtercontainer = document.querySelector('.record-sort-by-items');
    var filterlinks = document.querySelector('.record-sort-by-items>ul');
    var filterlinksheight = filterlinks.clientHeight + 10;
    // console.log(filterlinksheight);        
    
    if(filtercontainer.style.height !== filterlinksheight + "px"){
        
        closeSearchFilter();
        closeSettings();
        filtercontainer.style.transition = "1s ease all";
        filtercontainer.style.height = filterlinksheight + "px";
        filtercontainer.style.padding ="10px 0px";
        filtercontainer.style.
        boxShadow= "0px 0px 10px 2px rgba(0,0,0,.3)";
        
        
    }else{
        
        filtercontainer.style.transition = "1s ease all";
        filtercontainer.style.height = "0px";
        filtercontainer.style.padding ="0px";
        filtercontainer.style.
        boxShadow= "none";

    }

}

function showSearchFilter(){
    var filtercontainer = document.querySelector('.search-filter-links');
    var filterlinks = document.querySelector('.search-filter-links>ul');
    var filterlinksheight = filterlinks.clientHeight + 30;
    // console.log(filterlinksheight)
    
    if(filtercontainer.style.height !== filterlinksheight + "px"){
        
        closeFilterLink();
        closeSettings()
        filtercontainer.style.transition = "1s ease all";
        filtercontainer.style.height = filterlinksheight + "px";
        filtercontainer.style.padding ="10px 0px";
        filtercontainer.style.
        boxShadow= "0px 0px 10px 2px rgba(0,0,0,.2)";
        filtercontainer.style.padding ="10px 0px";
        
        
    }else{
        
        filtercontainer.style.padding ="0px";
        filtercontainer.style.transition = "1s ease all";
        filtercontainer.style.height = "0px";
        
        filtercontainer.style.
        boxShadow= "none";

    }

}

function openSettings(){
    var settingscontent = document.querySelector('.header-settings-link');
    var settingslink = document.querySelector('.header-settings-link>ul');
    var settingslinkheight = eval(settingslink.clientHeight + 10);

    if(settingscontent.style.height !== settingslinkheight + "px"){
        closeSearchFilter();
        closeFilterLink();

        settingscontent.style.height = settingslinkheight + "px";
        settingscontent.style.padding = "10px 0px";
        
    }else{
        
        settingscontent.style.padding = "0px";
        settingscontent.style.height = "0px";

    }

}

function closeSettings(){
    var settingscontent = document.querySelector('.header-settings-link');
    var settingslink = document.querySelector('.header-settings-link>ul');
    var settingslinkheight = eval(settingslink.clientHeight + 10);

    if(settingscontent.style.height !== "0px"){
        
        settingscontent.style.padding = "0px";
        settingscontent.style.height = "0px";

    }
    
}

function addfilter(value){
    var filterinput = document.getElementById('filter-value');

    filterinput.value = value;
    showSearchFilter();
}

function closeSearchFilter(){

    if(document.querySelector('.search-filter-links')){

        var filtercontainer = document.querySelector('.search-filter-links');
        var filterlinks = document.querySelector('.search-filter-links>ul');
        var filterlinksheight = filterlinks.clientHeight + 10;
        // console.log(filterlinksheight)
    
        if(filtercontainer.style.height !=="0px"){
            filtercontainer.style.padding ="0px";
            filtercontainer.style.transition = "1s ease all";
            filtercontainer.style.height = "0px";
            
            filtercontainer.style.
            boxShadow= "none";
    
        }
    }
}

function closeFilterLink(){

    if(document.querySelector('.record-sort-by-items')){

        var filtercontainer = document.querySelector('.record-sort-by-items');
        var filterlinks = document.querySelector('.record-sort-by-items>ul');
        var filterlinksheight = filterlinks.clientHeight + 10;
        // console.log(filterlinksheight);        
        closeSearchFilter();
    
        if(filtercontainer.style.height !== "0px"){
            
            filtercontainer.style.transition = "1s ease all";
            filtercontainer.style.height = "0px";
            filtercontainer.style.padding ="0px";
            filtercontainer.style.
            boxShadow= "none";
        }
    }


}

function openNotifictation(){
    var notificationContainer = document.querySelector('.header-notification-link');
    var notificationContent = document.getElementById('notification-details');
    var notificationContentcontainer = document.querySelector('.notification-details-content');
    var notificationcounter = document.querySelector('#notification-counter');
    var notificationspinner = document.querySelector('.notification-animation');
    
    if(notificationContainer.style.height !== 400 + "px"){
        
        if(notificationContent.clientHeight < notificationContentcontainer.getBoundingClientRect().height){
            notificationContent.style.overflowY = "scroll";
        }else{
            
            notificationContent.style.overflowY = "visible";
        }

        // console.log(notificationContentcontainer.getBoundingClientRect());
        notificationspinner.style.display = "flex";
        
        notificationContainer.style.height = 400 + "px";

        notificationContentcontainer.innerHTML = "";

        if (window.XMLHttpRequest) {
            // code for modern browsers
            var xhttp = new XMLHttpRequest();
          } else {
            // code for old IE browsers
            var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
         }
         
      
    //   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
        xhttp.onreadystatechange = function() {
        
            if (this.readyState == 4 && this.status == 200) {
        
                var notificationdata = this.responseText;

                function showNotif(){
                    notificationspinner.style.display = "none";
                    notificationContentcontainer.innerHTML = notificationdata
                    notificationcounter.style.display = "none";
                    notificationcounter.style.textContent = "0";
                }

                setTimeout(showNotif, 1000);

            }

        }

        
        xhttp.open("GET", "./functions/fetch_data.php?page=notification");
        xhttp.send();

        // notificationContainer.addEventListener("transitionend", ()=>{


        // }, {once:true})

    }else{
        notificationContent.style.overflowY = "visible";
        notificationContainer.style.height = "0px";
    }

}


function hideNav(){
    var navbar = document.querySelector('nav');
    var navwidth = navbar.clientWidth;
    
    var navcontainer = document.querySelector('.side-bar');
    var navbutton = document.querySelector('.nav-button button');
    var maincontainer = document.querySelector('.main-container');

    if(navbar.style.left !== "-" + navwidth + "px"){

        navbar.style.left = "-" + navwidth + "px";
        navcontainer.style.width = "0px";
        navcontainer.style.minWidth = "0px";
        maincontainer.style.width = "100%";
        navbutton.innerHTML = '<i class="fas fa-arrow-right"></i>';
        
    }else{
        
        navbar.style.left = "0px";
        navcontainer.style.width = "20%";
        navcontainer.style.minWidth = "250px";
        maincontainer.style.width = "80%";
        navbutton.innerHTML = '<i class="fas fa-arrow-left"></i>';

    }
}

function adjustnav(){

    var navbar = document.querySelector('nav');
    var navwidth = navbar.clientWidth;
    
    var navcontainer = document.querySelector('.side-bar');
    var navbutton = document.querySelector('.nav-button button');
    var maincontainer = document.querySelector('.main-container');

    navbar.style.left = "-" + navwidth + "px";
        navcontainer.style.width = "0px";
        navcontainer.style.minWidth = "0px";
        maincontainer.style.width = "100%";
        navbutton.innerHTML = '<i class="fas fa-arrow-right"></i>';

}

function copyrecordlink(){
    var link = document.querySelector('#share-input-box');
    var linkvalue = document.querySelector('#share-input-box').value;

    link.select();
    link.setSelectionRange(0, 999999);

    navigator.clipboard.writeText(linkvalue);

    alert("Linked Copied");
}

function calcp(){
    var inputquantity = document.getElementById('input-quantity');
    var outputquantity = document.getElementById('output-quantity');
    var rejectionquantity = document.getElementById('rejection-quantity');
    var orderquantity = document.getElementById('order-quantity');
    var totalquantity = document.getElementById('total');


    if(inputquantity.value.trim() === ""){
        var inputquantityvalue = 0;
    }else{
        
        if(isNaN(inputquantity.value.trim())){
            var inputquantityvalue = 0;
            
        }else{
            
            var inputquantityvalue = Number(inputquantity.value);
        }
    }

    

    if(outputquantity.value.trim() === ""){
        var outputquantityvalue = 0;
    }else{
        
        if(isNaN(outputquantity.value.trim())){
            var outputquantityvalue = 0;
            
        }else{
            
            var outputquantityvalue = Number(outputquantity.value);
        }
    }
    

    if(rejectionquantity.value.trim() === ""){
        var rejectionquantityvalue = 0;
    }else{
        
        if(isNaN(rejectionquantity.value.trim())){
            var rejectionquantityvalue = 0;
            
        }else{
            
            var rejectionquantityvalue = Number(rejectionquantity.value);
        }
    }


    if(orderquantity.value.trim() === ""){
        var orderquantityvalue = 0;
    }else{
        
        if(isNaN(orderquantity.value.trim())){
            var orderquantityvalue = 0;
            
        }else{
            
            var orderquantityvalue = Number(orderquantity.value);
        }
    }

    var totalquantityvalue = eval(inputquantityvalue + outputquantityvalue + rejectionquantityvalue + orderquantityvalue);

    console.log(totalquantityvalue);

    totalquantity.value = totalquantityvalue;



}

// function printPage(){

//     var page = document.querySelector('.records-content');

//     window.print();

// }


    




function fetchChartData(){


    if (window.XMLHttpRequest) {
        // code for modern browsers
        var xhttp = new XMLHttpRequest();
      } else {
        // code for old IE browsers
        var xhttp = new ActiveXObject("Microsoft.XMLHTTP");
     }
     
  
//   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  xhttp.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {

      var receiveddata = JSON.parse(this.responseText);

    // console.log(this.responseText)

      //   console.log(receiveddata);
      var adminCounter = document.querySelector("#admin-counter");
      var hourlyReportCounter = document.querySelector("#hourly-report-counter");
      var productionReportCounter = document.querySelector("#production-report-counter");

      function counteranim(el, num, loop, highest){

          var count = 0;
    const element = el;
        const newnum = num;
        const countloop = loop;
        const highestVal = highest;

        // console.dir(el);

          function writeCount(){

                if(count >= highestVal || count >= newnum){
                    var nextElement = element.nextElementSibling;
                    nextElement.style.opacity = "1";
                    nextElement.addEventListener('transitionend', ()=>{

                        nextElement.style.transition = "1s ease all";

                    }, {once:true})
                }
    
                if(element.textContent < highestVal && element.textContent !== highestVal + "+"){
                        
                
                        
                    if(element.textContent < newnum){
        
                        if(count > highestVal){

                            if(newnum > count){

                                element.textContent = highestVal + "+";

                            }else{
                                element.textContent = newnum;
                            }
    
    
                        }else{

                            if(newnum < count){

                                element.textContent = newnum;
                            }else{

                                element.textContent = count;
                            }
    
                        }
        
                        var addnum = Math.ceil(eval(newnum/countloop));
                        count += addnum;
    
                        // console.log(count);
                    } 
                }
    
            }

            
        if(element){
            
            setInterval(writeCount, 200); 
        }

      }

      if(receiveddata.totals.totalNotification > 0){
          var notificationCounter = document.getElementById('notification-counter');

          if(receiveddata.totals.totalNotification > 9){
              notificationcount = "9+";
          }else{
              notificationcount = receiveddata.totals.totalNotification;
          }

          notificationCounter.style.display = "inline-block";
          notificationCounter.textContent = notificationcount;
      }


      counteranim(adminCounter, receiveddata.totals.totalAdmin, 5, 99);
      counteranim(hourlyReportCounter, receiveddata.totals.totalHourlyReport, 5, 99);
      counteranim(productionReportCounter, receiveddata.totals.totalProductionReport, 5, 99);



      var hourlyReportarray = Array();
      var hourlyReportOpacity = Array();
      var productionReportarray = Array();

        for(dataValue in receiveddata.reports.hourlyReport){

            hourlyReportarray.push(receiveddata.reports.hourlyReport[dataValue]);

            var colorOpacity = (receiveddata.reports.hourlyReport[dataValue]/receiveddata.reports.hourlyReport["target"]);

            if(colorOpacity < 0.5){
                colorOpacity = 0.5;
            }

            hourlyReportOpacity.push(colorOpacity);


            
        }

        for(dataValue in receiveddata.reports.productionReport){

            productionReportarray.push(receiveddata.reports.productionReport[dataValue]);

            
        }

        const hourlylabels = [
            "7:30-8:30",
            "8:30-9:30",
            "9:30-10:30",
            "10:30-11:30",
            "11:30-12:30",
            "12:30-1:30",
            "1:30-2:30",
            "2:30-3:30",
            "3:30-4:30",
            "4:30-5:30",
            "6:00-8:00"
        ];
        
        const hourlydata = {
            labels: hourlylabels,
            datasets: [{
                label: 'HOURLY PRODUCTION REPORT',
                backgroundColor: [`rgba(3, 3, 99, ${hourlyReportOpacity[0]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[1]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[2]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[3]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[4]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[5]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[6]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[7]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[8]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[9]})`, `rgba(3, 3, 99, ${hourlyReportOpacity[10]})`],
                clip:{left: 8, top: false, right: -2, bottom: 0},
                barPercentage: 1,
                color: "red",barPercentage: 0.5,
                barThickness: 1,
                maxBarThickness: 3,
                minBarLength: 2,
                barThickness: 1,
                data: hourlyReportarray
            }]
        };
        
        const hourlyconfig = {
            type: 'bar',
            data: hourlydata,
            options: {
                legend: {
                    display: false
                }
                
                
            }
        };
        
        
        
        const productionlabels = [
            "Input Quantity",
            "Output Quantity",
            "Rejection Quantity",
            "Order Quantity",
        ];
        
        const productiondata = {
            labels: productionlabels,
            datasets: [{
                label: 'PRODUCTION CHART',
                backgroundColor: ['rgb(2, 73, 2)', 'rgb(250, 163, 2)', 'rgb(107, 3, 3)', 'rgb(3, 3, 99)'],
                color: "red",
                hoverBackgroundColor: ['rgb(1, 43, 1)', 'rgb(190, 125, 3)', 'rgb(71, 2, 2)', 'rgb(2, 2, 56)'],
                data: productionReportarray
            }]
        };
        
        const productionconfig = {
            type: 'doughnut',
            data: productiondata,
            options: {
                legend: {
                    display: false
                }
                
                
            }
        };

        if(document.getElementById('hourly-chart')){

            const hourlyChart = new Chart(
                document.getElementById('hourly-chart'),
                hourlyconfig
            );
        }

        if(document.getElementById('production-chart')){

            const productionChart = new Chart(
                document.getElementById('production-chart'),
                productionconfig
            );
        }


        
    //   console.log(hourlydata.datasets[0].data);
    }

  }

  xhttp.open("GET", "./functions/fetch_data.php?page=dashboard&data=graph", true);
  xhttp.send();

  


}

// setTimeout(fetchChartData, 0)


window.addEventListener('load', (e)=>{
    
    fetchChartData()
          
})

function scrollAnimation(element){
    // console.log(element.getBoundingClientRect());
    var element = element;

    startAnimation(element);

    // requestAnimationFrame(startAnimation(element));

    function startAnimation(element){

        if(element){
    
            element.style.opacity = "0";
        
        
                
            if(element.getBoundingClientRect().top <= (window.innerHeight/2) && element.getBoundingClientRect().bottom > 0){
            
                        
                element.style.opacity = "1";
                element.style.transition = "2s ease all";
                
            }else{
                
                element.style.transition = "2s ease all";
                element.style.opacity = "0";
                
            }
            var scrollValue = 0;
            var scrolldirection = null;
            var scrollEvent = {
                down: false,
                up : false
            }
            
            window.addEventListener('scroll', (e)=>{
    
                // console.log(window.pageYOffset);
    
                if(window.pageYOffset > scrollValue){
                    scrolldirection = "down";
                    scrollEvent.down = true;
                    scrollEvent.up = false;
                }else{
                    scrolldirection = "up";
                    scrollEvent.down = false;
                    scrollEvent.up = true;
                }
    
                scrollValue = window.pageYOffset;
                
                // console.log(window.scrollY + window.innerHeight);
                // console.log("body: " + document.querySelector('body').getBoundingClientRect().height);
    
                if(scrolldirection === "down"){

                    // console.log("height")

                    
                    if(element.getBoundingClientRect().height > window.innerHeight/2) {

                        // console.log(element.className + ": greater than");
                        
                        if(element.getBoundingClientRect().top <= (window.innerHeight/2) && element.getBoundingClientRect().bottom > 0){
            
                            
                            
                            if(!scrollEvent.up){
                                
                            }
                                
                            element.style.opacity = "1";
                            element.style.transition = "2 ease all";
                            
                        }else{
                            
                            element.style.transition = "2 ease all";
                            element.style.opacity = "0";
                            
                        }
                    }else{

                        
                        // console.log("top: " + element.getBoundingClientRect().top);
                        // console.log("height: " + element.getBoundingClientRect().height);

                        if(element.getBoundingClientRect().top >= (element.getBoundingClientRect().height) && element.getBoundingClientRect().bottom > 0){
                            
                            
                            
                            if(!scrollEvent.up){
                                
                            }
                                
                            element.style.opacity = "1";
                            element.style.transition = "2 ease all";
                            
                        }else{
                            
                            element.style.transition = "2 ease all";
                            element.style.opacity = "0";
                            
                        }

                    }
    
                }else{
    
                    // console.log(document.querySelector('.reports').getBoundingClientRect().top)
    
                    if(element.getBoundingClientRect().bottom >= (window.innerHeight/3) && element.getBoundingClientRect().top < window.innerHeight/2){
        
                        
                
                        
                        element.style.opacity = "1";
                        element.style.transition = "2 ease all";
                        
                    }else{
                        
                        element.style.transition = "2 ease all";
                        element.style.opacity = "0";
                        
                    }
    
                }
                
            })
        }
    }

    
}

var tableReport = document.querySelector('.reports');
var dashboardChartscontent = document.querySelector('.dashboard-charts');


scrollAnimation(tableReport);
scrollAnimation(dashboardChartscontent);


// drawDashboardChart();



