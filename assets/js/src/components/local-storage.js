let urlParams = window.location.search;
    
if (urlParams.indexOf('utm') > -1) {
    const queryString = Object.fromEntries(
                            new URLSearchParams(urlParams)
                        );

    if (queryString) {
        writeStorage('urlParams', queryString);
    }
}

export function removeStorage(name) {
    try {
        window.localStorage.removeItem(name);
        window.localStorage.removeItem(name + '_expires');
    } catch(e) {
        console.log('removeStorage: Error removing key ['+ key + '] from localStorage: ' + JSON.stringify(e) );
        return false;
    }
    return true;
}

export function writeStorage(key, value, expires) {
    
    let writeValue = '';
    
    if (typeof value === 'object') {
        writeValue =  JSON.stringify(value)
    } else {
        writeValue = value;
    }
    
    if (expires === undefined || expires === null) {
        expires = (24*60*60);
    } else {
        expires = Math.abs(expires);
    }
    
    let now = Date.now();  //millisecs since epoch time, lets deal only with integer
    let expiry = now + expires*1000; 
    
    window.localStorage.setItem(key, writeValue);
    window.localStorage.setItem(key + '_expires', expiry);
    
}

export function readStorage(key) {
    
    let value = null;
    let now = Date.now();
    
    let expires = window.localStorage.getItem(key+'_expires');
    if (expires === undefined || expires === null) { 
        expires = 0; 
    }
    
    if (expires < now) {// Expired
        removeStorage(key);
        return null;
    } else {
        if(key.indexOf('_expiresIn') > -1) { 
            value = window.localStorage.getItem(key);
        }
    
        if (typeof value !== null) {
            try {  
                return JSON.parse(value);  
            } catch(err) { 
                return value; 
            } 
        }
    }
}