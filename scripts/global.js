var pics = [
	'http://upload.wikimedia.org/wikipedia/en/5/53/Vanessa_Mae_-_Choreography_(Front).jpg',
	'http://vicanselmo.com/wp-content/uploads/2011/04/SlideN2.jpg',
	'https://lh5.googleusercontent.com/-H-bafwEGoo0/Tu-9kEuJIXI/AAAAAAAADSA/k0M4UNV0sdA/s250-c-k-no/Within%2BTemptation%2Bwallpaper%2B%252817%2529.jpg',
	'http://www.medazzarock.ch/music/interviews/2012/Epica.jpg',
	'http://www.metalinsider.net/site/wp-content/uploads/2012/01/metallica.jpg',
	'http://userserve-ak.last.fm/serve/_/35769621/Abney+Park.jpg',
	'http://www.bryanreesman.com/blog/wp-content/uploads/2009/11/23973661_Emilie_Autumn.jpg',
	'http://3.bp.blogspot.com/_qGUJmSshHZs/R9O8lc1cUsI/AAAAAAAAAEE/jupbki3le24/S1600-R/newbig.jpg',
	'http://www.acdc.com/sites/acdc/files/imagecache/600wide_max/acdchighwaytohell.jpg',
	'http://userserve-ak.last.fm/serve/500/8429177/Bond.jpg',
	'http://userserve-ak.last.fm/serve/500/46142261/Nightwish++930s.png',
	
	'http://userserve-ak.last.fm/serve/500/75622822/Xandria.png',
	'http://f0.bcbits.com/z/11/92/1192038949-1.png',
	'http://www.thesirenssound.com/wp-content/uploads/2010/04/Johnny-Hollow-Dirty-Hands-2008.jpg',
	'http://dirtybourbonrivershow.files.wordpress.com/2010/09/f56351046c8d4dda_905c9d3e4214a2eb_p.jpg',
	'http://www.vancouverticket.com/blog/wordpress/wp-content/uploads/2013/07/the-pretty-reckless-226158.png'
];

var genres = [
	'rock', 'punk', 'steampunk', 'metal', 'pop', 'gothic', 'classical', 'blues', 'jungle',
	'house', 'trance', 'techno', 'reggae', 'country', 'folk', 'opera', 'jazz'
];

genres.getRandom = function() {
	var count = random(1, 4);
	var tmp = genres.slice(0);
	var rt = '';
	for (var i=0; i<count; i++) {
		var x = tmp.splice(random(0, tmp.length), 1);
		rt += '<a href="#search:genre:' + x + '">' + x + '</a>';
		if (i+1<count) rt += ', ';
	}
	return rt;
}

function random(min, max) {
	return min + Math.floor(Math.random() * (max-min) );
}

function $(q) { return document.querySelector(q); }
function $$(q) { 
	var data = document.querySelectorAll(q);
	return Array.prototype.splice.call(data, 0);
}

function template(tpl, obj) {
	return tpl.replace(/\{\{([^}]+)\}\}/gm, function(all, f) {
		return obj[f] || '';
	});
}