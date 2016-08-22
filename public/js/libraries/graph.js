/**********

Ultimately, for added security, the functions used herein should be made to be part of js classes, 
thus reducing the dependence on global variables

There are three main sequences (dependent on timers) ...

initAll -		loads the data into global arrays, calls draw function, calls hide function then calls show function
				this is called at start-up and when user selectes a different date range, prompting a new data load

resetAll -		hides graphs, redraws them, then shows them  
				called by use-ranges toggle

refreshAll -	hides graphs and shows them
				called by graph type toggle since all that has to happen is to change the number of graphs displayed 

**********/

// sample data if not passed in - 3247
if (typeof sysid  == 'undefined') var sysid = 5;
if (typeof str  == 'undefined') var str = 1;
if (typeof days == 'undefined') var days = 90;
if (typeof unit == 'undefined') var unit = '';
if (typeof gtype == 'undefined' || gtype=="") var gtype = "vit";

// detect broewser and set flag if IE8 for conditional use later on
var browser = whatbrowser();
var nav = browser[0];
var ver = browser[1];
var ie8 = false;
	
// if ie8, then set control variable and ajust div offsets
if (nav == "MSIE" && ver < 9.0) {
	ie8 = true;
}

function whatbrowser() {
	var N= navigator.appName, ua= navigator.userAgent, tem;
	var M= ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
	if(M && (tem= ua.match(/version\/([\.\d]+)/i))!== null) M[2]= tem[1];
	M= M? [M[1], M[2]]: [N, navigator.appVersion, '-?'];
	return M;
}

var thishost = window.location.host;
var devOnly = thishost.match(/dev/g);

$(document).ready(function () {

	// base url for getting data
	var url = '/graphs/graph-data';

	var headerH		= 300;				// set header bar size
	var numGraphs	= 0;				// how many graphs do we start with?
	var maxGraphs	= 3;				// total number of possible graphs
	var loaddone	= 0;				// initialize loading done flag
	var drawdone	= 0;				// initialize loading done flag
	var drawcurrent	= 0;				// current graph being drawn
	var hidedone	= 0;				// initialize hide graphs done flag
	var showdone	= 0;				// initialize show graphs done flag
	var rangefilter	= 'fit';			// use provided ranges or let DY calculate them.
	var g			= [];				// object holders for our graphs
	var myTimer		= null;				// timer for wait loops
	var mydTimer	= null;				// timer for draw loops
	var unitfilter  = [];
	
    var	filtunit = unit;
    if (unit > 0) {
    	unitfilter	= [unit-1];			// list of units to filter
    	unit= 0 ;
	}
	
	var maxunits	= 4;				// the number of units for this call
	var dataskip	= 1;				// step factor in calculations

	// data arrays for graphing
	var lines = [];						// data to plot
	var labels = [];					// labels for data
	var unitnums = [];					// actual unit numbers
	var first = [];						// date of first element
	var last = [];						// date of last element
	var critical = [];					// critical thresholds for limit lines
	var maintenance = [];				// maintenance thresholds for limit lines
	var ylabel = [];					// y-axis labels
	var yfmt = [];						// y-axis format
	var errlbl = [];					// errors

	var ranges = [];					// range to plot if ranges
	ranges.ranges = [];
	ranges.limits = [];
	ranges.fit = [];

	var starttime = 0;
	var loadtime = 0;
	var blockRedraw = false;			// restricts redraw callback from repeating on each graph
	var oldxrange = [0,0];				// last zoom range values

	ylabel[1] = "Voltage (v)";
	ylabel[2] = "Impedance (mOhms)";
	ylabel[3] = "Degrees (C)";

	yfmt[1] = "v";
	yfmt[2] = "mOhms";
	yfmt[3] = "&deg;C";

	errlbl[1] = "Voltage";
	errlbl[2] = "Impedance";
	errlbl[3] = "Temperature";

	var gtypes = ['v','i','t'];

	// default checkboxes and drop-down value
	$('#'+rangefilter).prop('checked', true);
	$("#days option[value='"+days+"']").attr("selected", "selected");

	// status array - are we currently displayng this graph?
	var grphs = [];
	for (var i=1; i<=maxGraphs; i++) {
		grphs[i] = false;
		for (j=0; j<gtype.length; j++) {
			if (gtypes[i-1] == gtype[j]) {
				grphs[i] = true;
				$('#gd'+i).prop('checked', true);
				numGraphs++;
			}
		}
	}	

	// let's go!
	setDivSize();
	initAll();

	if (!devOnly) $('#loadtime').css('display','none');

	// set up listener to resize if window changes
	window.onresize = function(event) { setDivSize(); };

	////////////////////////////////////////
	///// wait for something to happen /////
	////////////////////////////////////////

/******************* Main Sequences ********************/

	/**
		Init Sequence
		- asynchronously load data files and wait for 'done' variables in sequence
	*/	
	function initAll() {
		$('.spinner').css('display','block');
		$('.spinner').html('<img src="/images/spinner.gif" /><br />Loading Graph Data');
		starttime = +new Date();
		loadGraphs();
		myTimer = setInterval(initLoadWait, 100);
	}
	function initLoadWait() {
		if (loaddone == maxGraphs) {
			clearInterval(myTimer);
			loadtime = +new Date() - starttime;
			$('.spinner').html('<img src="/images/spinner.gif" /><br />Creating Graphs');
			//$('#loadtime').html("Load time: "+loadtime/1000+" seconds.");
			drawGraphs();
			myTimer = setInterval(initDrawWait, 100);
		}
	}	
	function initDrawWait() {
		if (drawdone == maxGraphs) {
			clearInterval(myTimer);
			hideGraphs();
			myTimer = setInterval(initHideWait, 100);
		}
	}	
	function initHideWait() {
		if (hidedone == maxGraphs) {
			$('.spinner').html('');
			$('.spinner').css('display','none  ');
			clearInterval(myTimer);
			showGraphs();
		}
	}

	/**
		Reset Sequence
		- hide graphs, reset, then show graphs
	*/	
	function resetAll() {
		hideGraphs();
		myTimer = setInterval(resetHideWait, 100);
	}	
	function resetHideWait() {
		if (hidedone == maxGraphs) {
			clearInterval(myTimer);
			drawGraphs();
			myTimer = setInterval(resetDrawWait, 100);
		}
	}	
	function resetDrawWait() {
		if (drawdone == maxGraphs) {
			clearInterval(myTimer);
			showGraphs();
		}
	}

	/**
		Redfresh Sequence
		- hide graphs, then show graphs
	*/	
	function refreshAll() {
		hideGraphs();
		myTimer = setInterval(refreshAllWait, 100);
	}	
	function refreshAllWait() {
		if (hidedone == maxGraphs) {
			clearInterval(myTimer);
            // *** fastgraphs
            initAll();
		}
	}

/******************* Utility Functions ********************/

	/**
		load all graph data
		loaddone will be set to maxGraphs when all are complete
		don't load any graph twice
	*/
	function loadGraphs() {
		loaddone = 0;
        loadDataFile("1","v");		// voltage
        loadDataFile("2","i");		// impedance
		loadDataFile("3","t");		// temp
	}

	/**
		load all graph data
	*/
	function drawGraphs() {
   		drawdone = 0;
  		drawcurrent = 0;
   		mydTimer = setInterval(doDrawGraph, 100);
	}

	/**
		load graph data for each graph
		drawdone will be set to maxGraphs when all are complete
	*/
	function doDrawGraph() {
		if (drawdone == drawcurrent && drawdone != maxGraphs) {
			clearInterval(mydTimer);
			drawcurrent++;
			drawGraph(drawcurrent,"chart"+drawcurrent,"rgba(128,128,128,1)");
			mydTimer = setInterval(doDrawGraph, 100);
		}	
		if (drawdone == maxGraphs) clearInterval(mydTimer);
	}

	/**
		slide all graphs up in order and set global done variable
		hidedone will be set to maxGraphs when all are complete
	*/
	function hideGraphs() {
		hidedone = 0;
		$('#graphdiv3').slideUp(200, function() {
			$('#graphdiv2').slideUp(200, function () {
				$('#graphdiv1').slideUp(200, function () {
					$('#charts').css('left', '20px');
					setDivSize();
					hidedone = maxGraphs;
				});
			});
		});
	}

	/**
		slide visible graphs down - calls resize for graph on each step
		showdone will be set to maxGraphs when all are complete
	*/
	function showGraphs() {
		showdone = 0;
		showOneGraph(1);
		showOneGraph(2);
		showOneGraph(3);
	}
	function showOneGraph(num) {
		if (grphs[num]) { 
			$('#graphdiv'+num).slideDown({
				duration: 200,
				step: function() {
					if (lines[num].length) g[num].resize(); 
				}, 
				complete: function() { 
					showdone++; 
				}
			});					
		} else showdone++; 
	}


/******************* Misc. Functions ********************/

	/**
		Get height of current window for use during resizing
	*/	
	function getWindowSize() {
		// set default chart sizes for voltage and impedance
		if (document.body && document.body.offsetWidth) {
			winW = document.body.offsetWidth;
			winH = document.body.offsetHeight;
		}
		if (document.compatMode=='CSS1Compat' && document.documentElement && document.documentElement.offsetWidth ) {
			winW = document.documentElement.offsetWidth;
			winH = document.documentElement.offsetHeight;
		}
		if (window.innerWidth && window.innerHeight) {
			winW = window.innerWidth;
			winH = window.innerHeight;
		}
		return [winH,winW];
	}


	/**
		Reset height of all divs based on how many graphs there are
	*/
	function setDivSize() {
		var wsize = getWindowSize();
		var winh = wsize[0] - headerH - 80;
		var winw = wsize[1] - 110;
		$('#controls').css('height','80').css('width',winw);
		for (var i=1; i<=maxGraphs; i++ ) {
			$('#graphdiv'+i).css('height','240px').css('width',winw);
			$('#chart'+i).css('height','240px').css('width',winw);
		}
	}

	/**
		rtrim function for Javascript
	*/
	String.prototype.rtrim = function(s) { 
		return this.replace(new RegExp(s + "*$"),''); 
	};

	/**
		Load a dataset and update completion counter
	*/
	function loadDataFile(gnum, gtype) {
		var secureajax = new Canara.Libraries.Ajax();
		var data = { sysid: sysid, string: string, days: days, type: gtype, node: unit }
		secureajax.securecall({
			type: "POST",
			data: data,
			url: url,
			success: function (mydata) {

				//alert(mydata);

				// split incoming data on linefeeds and generate lines the graph can process
				var tmp = mydata.split("\n");
				lines[gnum] = [];
				labels[gnum] = [];
				ranges.ranges[gnum] = [];
				ranges.limits[gnum] = [];
				ranges.fit[gnum] = [];

				if (unit) units = 1;

                // tmp[0] is limits

				if (tmp[1] !== undefined) {

					$('#check' + gnum).css('display', 'block');

					// build label array from first row
					var tmpunits = tmp[1].split(",");
					var nunits = (parseInt(tmpunits.length)-1)/2;

					labels[gnum][0] = ["Date"];

					// create the other labels
					for (i=1; i<=nunits; i++) {
						if (gnum != 3) labels[gnum][i] = "Quadrant " + i + " ";
						else labels[gnum][i] = "External Probe";
					}

					// special case for single units
					if (unit > 0) labels[gnum][1] = "Quadrant " + unit + " ";

					// parse data into 'native' (array) format (skip frst line)
					var max = false;
					var min = false;
					var idx = 0;

					// loop through all the rows filling in the arrays
					for (i = 1; i < tmp.length; i += parseInt(dataskip)) {
						lines[gnum][idx] = [];

						//tmp[i] is the row of data starting with date
						var tmpdata = tmp[i].split(",");
						lines[gnum][idx][0] = new Date(tmpdata[0]);
						numloops = tmpdata.length - 1;

						for (j = 1; j <= numloops; j += 2)			// skip unit_num
						{
							// if not looking at single units, search for and pad null unit entries
							var unit_num = parseFloat(tmpdata[j]);

							// set unit names for filters
							unitnums[unit_num - 1] = unit_num;

							var item = parseFloat(tmpdata[j+1]);

							// ensure data is a number
							if (isNaN(item)) item = 0;

							lines[gnum][idx][unit_num] = item.toFixed(2);

							if (max === false || item > max) max = item;
							if (min === false || item < min) min = item;

						}
						last[gnum] = lines[gnum][idx][0];
						idx++;
					}

					// get first and last dates
					first[gnum] = lines[gnum][0][0];

					// assign other data arrays
					var parms = tmp[0].split(',');
					critical[gnum] = [parms[2], parms[3]];
					maintenance[gnum] = [parms[4], parms[5]];
					var rangediff = parseFloat((parms[3] - parms[2]) / 10);
					var fitdiff = parseFloat(Math.abs(max - min) / 10);

					// set limit arrays
					ranges.ranges[gnum] = [parms[0], parms[1]];
					ranges.limits[gnum] = [parseFloat(parms[2]) - rangediff, parseFloat(parms[3]) + rangediff];
					ranges.fit[gnum] = [min - fitdiff, max + fitdiff];

					// ensure ranges are in right sort order
					ranges.ranges[gnum].sort(function (a, b) {
						return a - b
					});
					ranges.limits[gnum].sort(function (a, b) {
						return a - b
					});
					ranges.fit[gnum].sort(function (a, b) {
						return a - b
					});

					// set temperature y axis label
					if (parms[6] == 1) ylabel[4] = "Temperature (&deg;C)";
					else ylabel[4] = "Temperature (&deg;F)";

				}

				if (tmp[1] === undefined) {
					loaddone++;
				} else {

					// check for mismatched data and fail elegantly
					if (lines[gnum][0].length != labels[gnum].length) {
						$('.spinner').css('display', 'none');
						alert("Error in " + errlbl[gnum] + " data. Please contact support.\n\nThere are " + lines[gnum][0].length + " items of data and " + labels[gnum].length + " labels.");
					} else {
						loaddone++;
					}
				}

			}
		});
	}


	/**
		draw a graph and update completion counter
	*/
	function drawGraph(gnum,gdiv,gcolor) {
		var colors = [gcolor];
		var myrange = ranges[rangefilter][gnum];

		// always default to fit if other ranges not specified
		if (myrange[0] === 0 && myrange[1] === 0) myrange = ranges.fit[gnum];

		// use filter if it exists
		var mylines = [];
		var mylabels = [];

		if (unit) unitfilter = false;

		if (unitfilter && unitfilter.length > 0) {
			for (var n = 0; n < (lines[gnum].length); n++) {
				mylines[n] = [];
				mylines[n][0] = lines[gnum][n][0];
				mylabels[0] = labels[gnum][0];

				for (var m = 0; m<unitfilter.length; m++) {
					mylines[n][m+1] = lines[gnum][n][unitfilter[m]+1];
					mylabels[m+1] = labels[gnum][unitfilter[m]+1];
				}
			}
		} else {
			mylines = lines[gnum];
			mylabels = labels[gnum];
		}

		// suppress y-labels if IE8
		if (ie8) ylabel[gnum] = "";

        // force a little range...
        if (myrange[0] == myrange[1]) {
            myrange[0] -= .1;    
            myrange[1] += .1;    
        }

		if (mylines.length > 0) {

    		g[gnum] = new Dygraph(document.getElementById(gdiv), mylines, { 
				labels: mylabels,
				drawXAxis: true,
				drawYAxis: true,
				drawXGrid: true,
				drawYGrid: true,
				valueRange: myrange,
				ylabel: ylabel[gnum],
				fillGraph: false,
				labelsShowZeroValues: true,
				highlightCircleSize: 0,
				strokeWidth: 0.4,
				gridLineColor: '#dedede',
				axisLabelColor: '#999999',
				colors: colors,
				rightGap: 15,
				highlightSeriesBackgroundAlpha: .6,
				highlightSeriesOpts: {
					strokeWidth: 0.5,
					strokeBorderWidth: 1,
					strokeBorderColor: "#6699ff",
					highlightCircleSize: 4
				},
				labelsDivWidth: 300,
				labelsDivStyles: {
					'text-align': 'right'
				},
				xAxisLabelWidth: 70,
                axisLabelFontSize: 13,
				axes: {
					x: {
						pixelsPerLabel:80,
						valueFormatter: function(ms) {
							return ' ' + new Date(ms).strftime('%m/%d/%Y %T') + ' ';
						},
						axisLabelFormatter: function(d, gran) {
							return Dygraph.zeropad(d.strftime('%m/%d/%Y'));
						}
					},
					y: {
						valueFormatter: function(y) {
							//if (!y) return ' null ';
							return ' ' + y + ' ' + yfmt[gnum] + ' ';
						}
					}
				},
				drawCallback: function(me, initial) {
					var xrange = me.xAxisRange();
					if ((xrange[0] == oldxrange[0] && xrange[1] == oldxrange[1]) || blockRedraw || initial) return;
					else {
						blockRedraw = true;
						for (var j = 1; j <= maxGraphs; j++)
						{
							if (gnum == j) continue;	// don't draw if this graph or if graph diesn't exist
							else {
								g[j].updateOptions({
									dateWindow: xrange
								});
							}
						}
						blockRedraw = false;
						oldxrange = xrange;
					}
				},
				underlayCallback: function(canvas, area, g) {
					// critical threshold lines
					var bottom_left = g.toDomCoords(new Date(first[gnum]), critical[gnum][0]);
					var top_right = g.toDomCoords(new Date(last[gnum]), critical[gnum][0]);
					var left = bottom_left[0];
					var bottom = bottom_left[1];
					var right = top_right[0];
					var top = top_right[1]+5;
					canvas.fillStyle = "rgba(250, 0, 0, 1)";
					canvas.fillRect(left, bottom, right-left, 1);

					bottom_left = g.toDomCoords(new Date(first[gnum]), critical[gnum][1]);
					top_right = g.toDomCoords(new Date(last[gnum]), critical[gnum][1]);
					left = bottom_left[0];
					bottom = bottom_left[1];
					right = top_right[0];
					top = top_right[1]+5;
					canvas.fillStyle = "rgba(250, 0, 0, 1)";
					canvas.fillRect(left, bottom, right-left, 1);

					// maintenance threshold lines
					bottom_left = g.toDomCoords(new Date(first[gnum]), maintenance[gnum][0]);
					top_right = g.toDomCoords(new Date(last[gnum]), maintenance[gnum][0]);
					left = bottom_left[0];
					bottom = bottom_left[1];
					right = top_right[0];
					top = top_right[1]+5;
					canvas.fillStyle = "rgba(255, 220, 0, 1)";
					canvas.fillRect(left, bottom, right-left, 1);

					bottom_left = g.toDomCoords(new Date(first[gnum]), maintenance[gnum][1]);
					top_right = g.toDomCoords(new Date(last[gnum]), maintenance[gnum][1]);
					left = bottom_left[0];
					bottom = bottom_left[1];
					right = top_right[0];
					top = top_right[1]+5;
					canvas.fillStyle = "rgba(255, 220, 0, 1)";
					canvas.fillRect(left, bottom, right-left, 1);
					drawdone++;
				}
			});

			g[gnum].setSelection(false, mylabels[2], false);
		} else {
			var nodata = "No data loaded for this graph in this date range.";
			$('#chart'+gnum).html(nodata);
			drawdone++;
		}
	}

/*****  jquery methods called during execution *****/
	

	// // change the number of days of data to analyze
	// $('#days').change(function() {
	// 	//$('<input>').attr({ type: 'hidden', name: 'audname', value:audname }).appendTo('form');
	// 	var serializedData = $('form').serialize();
	// 	var secureajax = new Canara.Libraries.Ajax();
	// 	secureajax.securecall({
	// 		url: '/graphs/string-graph',
	// 		data: serializedData,
	// 		success: function (data) {
    //
	// 		}
	// 	});
	// });

	// $('#interval').change(function() {
	// 	dataskip = $(this).val();
	// 	hideGraphs();
	// 	initAll();
	// });


    // turn graphs on and off
	$('.dgraphs').click(function() {
		clearInterval(myTimer);
		var id = $(this).attr('id').substr(2);
		if (this.checked) {
			grphs[id] = true;
			numGraphs++;
		} else {
			grphs[id] = false;
			numGraphs--;
		}
        // *** fastgraphs
		refreshAll();
	});

	// toggle ranges flag
	$('.ranges').click(function() {
		clearInterval(myTimer);
		var id = $(this).attr("id");
		rangefilter = id;
		resetAll();
	});

	$('#setfilter').click(function(e) {
		e.preventDefault();
		clearInterval(myTimer);

		unitfilter = [];
		var tmp = $('#filter').val();
		if (tmp) {
			tmp = tmp.replace(/\ /g,'');
			var items = tmp.split(',');
			var k = 0;
			for (var i=0; i<items.length; i++) {
				var n = items[i].indexOf('-');
				if (n == -1) unitfilter[k++] = unitnums.indexOf(parseInt(items[i]));
				else {
					var tmp2 = items[i].split('-');
					var min = parseInt(tmp2[0],10);
					var max = parseInt(tmp2[1],10);
					for (var j=min; j<=max; j++) {
						var tmpunit = unitnums.indexOf(j);
						if (tmpunit != -1) unitfilter[k++] = tmpunit;
					}
				}
			}
			drawGraphs();
		}	
	});

	$('#clearfilter').click(function(e) {
		e.preventDefault();
		$('#filter').val('');
		unitfilter = [];
		drawGraphs();
	});

	$(document).keyup(function(e){
		if (e.keyCode == 38) {
			if (unitfilter.length != 1) {
				unitfilter = [];
				unitfilter[0] = 0;
			}	
			else {
				if (unitfilter[0] < unitnums.length-1) unitfilter[0]++;
				else unitfilter[0] = 0;
			}
			$('#filter').val(unitnums[unitfilter[0]]);
			drawGraphs();
		}
		if (e.keyCode == 40) { 
			if (unitfilter.length != 1) {
				unitfilter[0] = unitnums.length-1;
			}
			else {
				if (unitfilter[0] > 0)	unitfilter[0]--;
				else unitfilter[0] = unitnums.length-1;
			}	
			$('#filter').val(unitnums[unitfilter[0]]);
			drawGraphs();
		}
	});

	$('#filter').keydown(function (e) {
		if(e.keyCode == 13){
			$('#setfilter').click();
		}
	});

	$('#header_icon_info').click(function(e) {
		e.preventDefault();
		$('#helpfile').css('display','block');
		$('#helpfile').load('/include/graphhelp.html');
	}).css('cursor','pointer');

	$('#helpfile').click(function(e) {
		e.preventDefault();
		$(this).css('display','none');	
	});

	$('.errormsg').click(function() {
		$(this).animate({'top':'-=10000'},500);
	});

    function setFilter(unit) {
        unitfilter[0] = unit;
        $('#filter').val(unit);
    }

    if (unitfilter[0] >= 0) {
        $('#filter').val(unitfilter[0]+1);
        $('#filter').prop('disabled',true);
        $('#setfilter').css('display','none');
        $('#clearfilter').css('display','none');
    }
        
});
