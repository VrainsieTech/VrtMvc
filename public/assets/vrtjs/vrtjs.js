const  app_version = "1.0.0"; //PWA app versioning

document.addEventListener("DOMContentLoaded", function () {
    window.vrtmvc = {
        ajax: function (url, data = {}, method = "POST", callback = null) {
            fetch(url, {
                method: method,
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (callback) callback(result);
            })
            .catch(error => console.error("AJAX Error:", error));
        },

        submitForm: function (formId, callback) {
            let form = document.getElementById(formId);
            if (!form) return;

            form.addEventListener("submit", function (event) {
                event.preventDefault();
                let formData = new FormData(form);
                let data = Object.fromEntries(formData.entries());

                window.vrtmvc.ajax(form.action, data, form.method, function (response) {
                    if (callback) callback(response);
                });
            });
        }
    };
});


function nav(pg) {location.href=pg;}

function showHide(elm) {
	const elem = document.getElementById(elm);
	if(elem.display.style === 'none'){
        elem.style.display = 'block';
    } else {
        elem.style.display = 'none';
    }
}



function swal(elm,rdr ='nn') {
    //err scs handler
    const element = document.getElementById(elm);
    setTimeout(function(){
    element.style.transition = 'width 2s linear';
    element.style.width = '0';
    element.innerText="";
    setTimeout(function(){
        element.style.display='none';
        if(rdr != 'nn'){nav(rdr)}
    },2000);
    },6000);
}


function minmax(elm){
    //input max and min on forms
    const mmv = document.getElementById(elm);
    var minn= parseInt(mmv.getAttribute('min'));
    var maxx= parseInt(mmv.getAttribute('max'));
    var val = mmv.value;
    if(val < minn){
      mmv.style.color='red';
    } else if (val > maxx){
        mmv.style.color='red';
    }else {mmv.style.color='green';}
    
}



function copy(elm,belm){
    const val = document.getElementById(elm);
    const btn = document.getElementById(belm);
    val.select();
    val.setSelectionRange(0,99999);
    
    navigator.clipboard.writeText(val.value);
    
    btn.style.backgroundColor='green';
    btn.innerHTML='Content Copied';
}



// Ensure that the browser supports the service worker API 
if (navigator.serviceWorker) { 
  // Start registration process on every page load 
  window.addEventListener('load', () => { 
      navigator.serviceWorker 
          .register('service-worker.js') 
          // Gives us registration object 
          .then(reg => console.log('Service Worker Registered'))
          .catch(swErr => console.log( 
                `Service Worker Installation Error: ${swErr}}`)); 
    }); 
} 



window.addEventListener('load', () => {
  const installedVersion = localStorage.getItem('installedVersion');
  let deferredPrompt; // Declare deferredPrompt in the outer scope

  window.addEventListener('beforeinstallprompt', (event) => {
    // Prevent Chrome 67 and earlier from automatically showing the prompt
    event.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = event;
    // Update UI to notify the user they can add to home screen
    console.log('loaded and fired');
  });

  function showInstallPrompt() {
    const installButton = document.getElementById('installButton');
    installButton.style.display = 'block';

    installButton.addEventListener('click', () => {
      if (deferredPrompt) { // Check if deferredPrompt is defined
        deferredPrompt.prompt();

        deferredPrompt.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === 'accepted') {
            console.log('User accepted the A2HS prompt');
            localStorage.setItem('installedVersion', app_version);
            installButton.style.display = 'none';
          } else {
            console.log('User dismissed the A2HS prompt');
          }
          deferredPrompt = null; // Important: Reset deferredPrompt
        });
      } else {
        console.log("User likely already installed.");
        localStorage.setItem('installedVersion', app_version);
        installButton.style.display = 'none';
      }
    });
  }

  if (!navigator.standalone && installedVersion != app_version) {
    showInstallPrompt();
  }

  if (installedVersion != app_version) {
    showInstallPrompt(); 
  }
});


