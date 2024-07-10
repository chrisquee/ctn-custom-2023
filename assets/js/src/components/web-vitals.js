import {onFCP, onLCP, onINP, onCLS, onTTFB, onFID} from 'web-vitals/attribution';

function sendToGA(name, delta, id) {

    // Set the event params
    let eventParams = {
        event: 'web_vitals',
        cwv_metric: name.name,
        // Google Analytics metrics must be integers, so the value is rounded.
        // For CLS the value is first multiplied by 1000 for greater precision
        // (note: increase the multiplier for greater precision if needed).
        cwv_value: Math.round(name.name === 'CLS' ? name.delta * 1000 : name.delta),
        // The 'id' value will be unique to the current page load. When sending
        // multiple values from the same page (e.g. for CLS), Google Analytics can
        // compute a total by grouping on this ID (note: requires `eventLabel` to
        // be a dimension in your report).
        cwv_id: name.id,
        cwv_rating: name.rating,
        cwv_target: ''
    };

    switch (name.name) {
        case 'CLS':
            eventParams.cwv_target = name.attribution.largestShiftTarget;
            break;
        case 'LCP':
            eventParams.cwv_target = name.attribution.element;
            break;
        case 'FID':
        case 'INP':
            eventParams.cwv_target = name.attribution.eventTarget;
            break;
    }

    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push(eventParams);
    
    console.log(window.dataLayer);
}

onCLS(sendToGA);
onINP(sendToGA);
onLCP(sendToGA);
onFCP(sendToGA);
onTTFB(sendToGA);
onFID(sendToGA);