jQuery(function($) {
    
    if ($('.cq-cta-countdown').length) {
        update_countdowns();
    }
    
});
       
function update_countdowns() {
    
    $('.cq-cta-countdown').each(function() {
        
        var cdDate = $(this).attr('data-enddate');
        var cdTime = $(this).attr('data-endtime');
        var wrapElem = $(this);
        var daysElem = $(this).find('.days-content');
        var hoursElem = $(this).find('.hours-content');
        var minutesElem = $(this).find('.minutes-content');
        var secondsElem = $(this).find('.seconds-content');
        
        var endMessage = $(this).attr('data-endmessage');
        
        var countDownDate = new Date(cdDate + ' ' + cdTime).getTime();
        var newDays = '';
        var newHours = '';
        var newMinutes = '';
        var newSeconds = '';

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();
    
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
    
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            var daysClass = '';
            var hoursClass = '';
            var minutesClass = '';
            var secondsClass = '';
            
            if (days != newDays) {
                if (Number.isInteger((days + 1) / 10)) {
                    daysClass = 'active-' + toString(days).length;
                } else {
                    daysClass = 'active-1';
                }
                
                var daysHTML = '<span class="days ' + daysClass + '">' + String(days).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>') + '</span>';
                daysElem.html(daysHTML);
                
                daysElem.find('.days > span').each(function() {
                    var dataText = $(this).text();
                    $(this).attr('data-number', dataText);
                    
                    if (newDays == '') {
                        $(this).attr('data-numberold', dataText);
                    } else {
                        if (dataText == '0') {
                           $(this).attr('data-numberold', 9); 
                        } else {
                            $(this).attr('data-numberold', Number(dataText) + 1); 
                        }
                    }
                });
            } else {
                var daysHTML = '<span class="days finished">' + String(days).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>') + '</span>';
                daysElem.html(daysHTML);
            }
            
            if (hours != newHours) {
                if (Number.isInteger((hours + 1) / 10)) {
                    hoursClass = 'active';
                } else {
                    hoursClass = 'active-1';
                }
                
                var hoursHTML = '<span class="hours ' + hoursClass + '">' + String(hours).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>') + '</span>';
                hoursElem.html(hoursHTML);
                
                hoursElem.find('.hours > span').each(function() {
                    var dataText = $(this).text();
                    $(this).attr('data-number', dataText);
                    
                    if (newHours == '') {
                        $(this).attr('data-numberold', dataText);
                    } else {
                        if (dataText == '0') {
                           $(this).attr('data-numberold', 9); 
                        } else {
                            $(this).attr('data-numberold', Number(dataText) + 1); 
                        }
                    }
                });
            } else {
                var hoursHTML = '<span class="hours finished">' + String(hours).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>') + '</span>';
                hoursElem.html(hoursHTML);
            }
            
            if (minutes != newMinutes) {
                if (Number.isInteger((minutes + 1) / 10)) {
                    minutesClass = 'active';
                } else {
                    minutesClass = 'active-1';
                }
                
                var minutesHTML = '<span class="minutes ' + minutesClass + '">' + String(minutes).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>') + '</span>';
                minutesElem.html(minutesHTML);
                
                minutesElem.find('.minutes > span').each(function() {
                    var dataText = $(this).text();
                    $(this).attr('data-number', dataText);
                    
                    if (newMinutes == '') {
                        $(this).attr('data-numberold', dataText);
                    } else {
                        if (dataText == '0') {
                           $(this).attr('data-numberold', 9); 
                        } else {
                            $(this).attr('data-numberold', Number(dataText) + 1); 
                        }
                    }
                });
                
            } else {
                var minutesHTML = '<span class="minutes finished">' + String(minutes).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>') + '</span>';
                minutesElem.html(minutesHTML);
            }
            
            if (seconds != newSeconds) {
                if (Number.isInteger((seconds + 1) / 10)) {
                    secondsClass = 'active';
                } else {
                   secondsClass = 'active-1';
                }
                
                var secondsHTML = '<span class="seconds ' + secondsClass + '">' + String(seconds).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>') + '</span>';
                secondsElem.html(secondsHTML).find('.seconds > span').text;
                
                secondsElem.find('.seconds > span').each(function() {
                    var dataText = $(this).text();
                    $(this).attr('data-number', dataText);
                    
                    if (newSeconds == '') {
                        $(this).attr('data-numberold', dataText);
                    } else {
                        if (dataText == '9') {
                           $(this).attr('data-numberold', 0); 
                        } else {
                            $(this).attr('data-numberold', Number(dataText) + 1); 
                        }
                    }
                    
                });
            } else {
                var secondsHTML = '<span class="seconds finished">' + String(seconds).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>') + '</span>';
                secondsElem.html(secondsHTML).find('.seconds > span').text;
            }
            

            // Output the result in an element with id="demo"
           /* var daysHTML = '<span class="days ' + daysClass + '">' + String(days).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>'); + '</span>';
            var hoursHTML = '<span class="hours ' + hoursClass + '">' + String(hours).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>'); + '</span>';
            var minutesHTML = '<span class="minutes ' + minutesClass + '">' + String(minutes).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>'); + '</span>';
            var secondsHTML = '<span class="seconds ' + secondsClass + '">' + String(seconds).padStart(2, '0').replace(/(\d)/g, '<span>$1</span>'); + '</span>';
            
            daysElem.html(daysHTML);
            hoursElem.html(hoursHTML);
            minutesElem.html(minutesHTML);
            secondsElem.html(secondsHTML);*/
            
            newDays = days;
            newHours = hours;
            newMinutes = minutes;
            newSeconds = seconds;

            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                wrapElem.html('<span class="end-message">' + endMessage + '</span>');
            }
        }, 1000);
        
    });
}