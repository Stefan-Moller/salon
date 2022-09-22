F1.Date = {  

	days: {
  	long: [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ],
  	short: [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ],
	},

	months: {
  	long: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ],
  	short: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],
  },

  formatLong: function( date ) {
    // console.log('Date::formatLong(),', date );
    const yyyy = date.getFullYear(), m = date.getMonth(), d = date.getDate(), b = date.getDay(),
    dd = (d < 10) ? '0'+d : d, ddd = F1.Date.days.short[b], M = F1.Date.months.long[m];
    return `${ddd}, ${dd} ${M} ${yyyy}`;
  },

  formatYmd: function( date ) {
    // console.log('Date::formatYmd(),', date );
    const yyyy = date.getFullYear(), m = date.getMonth() + 1, d = date.getDate(),
    mm = m < 10 ? '0'+m : m, dd = d < 10 ? '0'+d : d;
    return `${yyyy}-${mm}-${dd}`;
  },

  parseLong: function( longDateStr ) {
    // console.log('Date::parseLong(), longDateStr =', longDateStr );
    if ( ! longDateStr ) return null;
    // NB: VARS (with `array.pop` assign) declaration order is crutial! 
    const parts = longDateStr.split(' '), months = F1.Date.months.long, year = parseInt(parts.pop());
    let month_term = parts.pop(), day = parseInt(parts.pop()) , month = months.indexOf( month_term );
    // console.log('Date::parseLong(), vals:', { parts, year, month_term, months, month, day });
    if ( month >= 0 ) return new Date( year, month, day );
    month_term = month_term.toLowerCase(); for ( let i=0; i < months.length; i++ ) { 
      if ( months[i].toLowerCase().includes(month_term) ) { month = i; break; } }
    return month >= 0 ? new Date( year, month, day ) : new Date();
  },

  parseYmd: function( sqlDateStr ) {
    // console.log('Date::parseYmd(), sqlDateStr =', sqlDateStr );
    return sqlDateStr ? new Date( sqlDateStr ) : null;
  },

}
