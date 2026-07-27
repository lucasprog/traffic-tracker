(function () {
    const traff_visitor_id = localStorage.getItem('traff_visitor_id') ?? crypto.randomUUID();
    localStorage.setItem("traff_visitor_id",traff_visitor_id);
    console.log('Traffic Tracker is running...')
    
    function tracking(){
        fetch("http://localhost/page/tracking", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                "name": document.title,
                "route": window.location.pathname,
                "visitor_id": traff_visitor_id,
                "domain": window.location.origin
            })
        });
    }
    const originalPushState = history.pushState;
    const originalReplaceState = history.replaceState;

    function onLocationChange() {
        console.log("Tracking page...",window.location.pathname);
        tracking();
    }

    history.pushState = function (...args) {
        originalPushState.apply(this, args);
        onLocationChange();
    };

    history.replaceState = function (...args) {
        originalReplaceState.apply(this, args);
        onLocationChange();
    };

    window.addEventListener("popstate", onLocationChange);

    // Initial page
    onLocationChange();
})();