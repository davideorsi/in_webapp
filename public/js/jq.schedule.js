

(function($) {
    $.fn.timeSchedule = function(options){
        var defaults = {
            rows : {},
            startTime: "07:00",
            endTime: "19:30",
            widthTimeX:40,		// 1cell辺りの幅(px)
            widthTime:15,		// 区切り時間(秒)
            timeLineY:50,		// timeline height(px)
            timeLineBorder:1,	// timeline height border
            timeBorder:1,		// border width
            timeLinePaddingTop:0,
            timeLinePaddingBottom:0,
            headTimeBorder:1,	// time border width
            dataWidth:180,		// data width
            verticalScrollbar:20,	// vertical scrollbar width
            // event
            init_data: null,
            on_drop: null,
            on_out: null,
            change: null,
            click: null,
            append: null,
            time_click: null,
            debug:""			// debug selecter
        };
        this.calcStringTime = function(string) {
            var mom=moment(string,"YYYY-MM-DD HH:mm");
            return mom.unix();
        };
        
        
        this.calcStringTimeStart = function(string) {
            var mom=moment(string,"YYYY-MM-DD HH:mm").startOf('day');
            return mom.unix()+60*60;
        };
        
        this.formatTime = function(min) {
            var time = moment(min*1000);
            return time.format('HH:mm');
        };
        
        this.formatTimeFull = function(min) {
            var time = moment(min*1000);
            return time.format('YYYY-MM-DD HH:mm');
        };

        var setting = $.extend(defaults,options);
        this.setting = setting;
        var scheduleData = new Array();
        var timelineData = new Array();
        var $element = $(this);
        var element = (this);
        var tableStartTime = element.calcStringTime(setting.startTime)-element.calcStringTimeStart(setting.startTime);
        var tableEndTime = element.calcStringTime(setting.endTime)-element.calcStringTimeStart(setting.startTime);
        var currentNode = null;
        tableStartTime -= (tableStartTime % setting.widthTime);
        tableEndTime -= (tableEndTime % setting.widthTime);

        this.getScheduleData = function(){
            return scheduleData;
        }
        this.getTimelineData = function(){
            return timelineData;
        }
        // 現在のタイムライン番号を取得
        this.getTimeLineNumber = function(top){
            var num = 0;
            var n = 0;
            var tn = Math.ceil(top / (setting.timeLineY + setting.timeLinePaddingTop + setting.timeLinePaddingBottom));
            for(var i in setting.rows){
                var r = setting.rows[i];
                var tr = 0;
                if(typeof r["schedule"] == Object){
                    tr = r["schedule"].length;
                }
                if(currentNode && currentNode["timeline"]){
                    tr ++;
                }
                n += Math.max(tr,1);
                if(n >= tn){
                    break;
                }
                num ++;
            }
            return num;
        }
        // 背景データ追加
        this.addScheduleBgData = function(data){
            var st = Math.ceil((data["start"] - tableStartTime) / setting.widthTime);
            var et = Math.floor((data["end"] - tableStartTime) / setting.widthTime);
            var $bar = jQuery('<div class="sc_bgBar"><span class="text"></span></div>');
            var stext = element.formatTime(data["start"]);
            var etext = element.formatTime(data["end"]);
            var snum = element.getScheduleCount(data["timeline"]);
            $bar.css({
                left : (st * setting.widthTimeX),
                top : 0,
                width : ((et - st) * setting.widthTimeX),
                height : $element.find('.sc_main .timeline').eq(data["timeline"]).height()
            });
            if(data["text"]){
                $bar.find(".text").text(data["text"]);
            }
            if(data["class"]){
                $bar.addClass(data["class"]);
            }
            //$element.find('.sc_main').append($bar);
            $element.find('.sc_main .timeline').eq(data["timeline"]).append($bar);
        }
        // スケジュール追加
        this.addScheduleData = function(data){
            var st = Math.ceil((data["start"] - tableStartTime) / setting.widthTime);
            var et = Math.floor((data["end"] - tableStartTime) / setting.widthTime);
            var $bar = jQuery('<div class="sc_Bar"><span class="head"><span class="time"></span></span><span class="text" style="margin-bottom:4px;"></span></div>');

            for( var i in data['png']){
				var png= data['png'][i];
				$bar.append("<span class='glyphicon glyphicon-user' style='margin:4px; font-size:1.6em; color:"+png['color']+";' title='"+png['Nome']+"'><input type='hidden' value='"+png['ID']+"' class='png'></input></span>");	
			}
            for( var i in data['pngminori']){
				var png= data['pngminori'][i];
				$bar.append("<span class='glyphicon glyphicon-user' style='margin:4px; font-size:1.6em; color:"+png['color']+";' title='"+png['nomeuser']+': '+png['PNG']+"'><input type='hidden' value='"+png['ID']+"' class='pngminori'></input></span>");	
			}
			$bar.find(".glyphicon").draggable({ revert: "valid"}).tooltip();
			var $trash = $("<span class='glyphicon glyphicon-trash' style='right:0px; margin:4px; font-size:1.6em;'></span").droppable({
					drop: function(event, ui) {
						var minori=false;
						if ($(ui.draggable).children().hasClass('pngminori')){
							minori = true;
							} 
						var ID = $(ui.draggable).children().val();
						setting.on_out(data["id"],ID,minori)
					}	
				});
				
			$bar.append($trash);	
            var stext = element.formatTime(data["start"]);
            var etext = element.formatTime(data["end"]);
            var snum = element.getScheduleCount(data["timeline"]);
            $bar.css({
                left : (st * setting.widthTimeX),
                top : ((snum * setting.timeLineY) + setting.timeLinePaddingTop),
                width : ((et - st) * setting.widthTimeX),
                height : (setting.timeLineY)
            });
            $bar.find(".time").text(stext+"-"+etext);
            if(data["text"]){
                $bar.find(".text").text(data["text"]);
            }
            if(data["class"]){
                $bar.addClass(data["class"]);
            }
            

            //$element.find('.sc_main').append($bar);
            $element.find('.sc_main .timeline').eq(data["timeline"]).append($bar);
            

            
            // データの追加
            scheduleData.push(data);
            // key
            var key = scheduleData.length - 1;
            $bar.data("sc_key",key);

            $bar.on("click",function(){
                // コールバックがセットされていたら呼出
                if(setting.click){
                    if(jQuery(this).data("dragCheck") !== true && jQuery(this).data("resizeCheck") !== true){
                        var node = jQuery(this);
                        var sc_key = node.data("sc_key");
                        setting.click(node, scheduleData[sc_key]);
                    }
                }
            });

            var $node = $element.find(".sc_Bar");
            $node.droppable({
				accept: ".todrag",
				drop: function(event, ui) {
					var node = jQuery(this);
                    var sc_key = node.data("sc_key");
					node.append($(ui.draggable).clone().tooltip());
					if (setting.on_drop){
						setting.on_drop(scheduleData[sc_key],$(ui.draggable).children('.png').val());
					}
				}
				});
            // move node.
            $node.draggable({
                grid: [ setting.widthTimeX, 1 ],
                containment: ".sc_main",
                helper : 'original',
                start: function(event, ui) {
                    var node = {};
                    node["node"] = this;
                    node["offsetTop"] = ui.position.top;
                    node["offsetLeft"] = ui.position.left;
                    node["currentTop"] = ui.position.top;
                    node["currentLeft"] = ui.position.left;
                    node["timeline"] = element.getTimeLineNumber(ui.position.top);
                    node["nowTimeline"] = node["timeline"];
                    currentNode = node;
                },
                drag: function(event, ui) {
                    jQuery(this).data("dragCheck",true);
                    if(!currentNode){
                        return false;
                    }
                    var $moveNode = jQuery(this);
                    var sc_key = $moveNode.data("sc_key");
                    var originalTop = ui.originalPosition.top;
                    var originalLeft = ui.originalPosition.left;
                    var positionTop = ui.position.top;
                    var positionLeft = ui.position.left;
                    var timelineNum = element.getTimeLineNumber(ui.position.top);
                    // 位置の修正
                    //ui.position.top = Math.floor(ui.position.top / setting.timeLineY) * setting.timeLineY;
                    //ui.position.top = element.getScheduleCount(timelineNum) * setting.timeLineY;
                    ui.position.left = Math.floor(ui.position.left / setting.widthTimeX) * setting.widthTimeX;


                    //$moveNode.find(".text").text(timelineNum+" "+(element.getScheduleCount(timelineNum) + 1));
                    if(currentNode["nowTimeline"] != timelineNum){
                        // 高さの調節
                        //element.resizeRow(currentNode["nowTimeline"],element.getScheduleCount(currentNode["nowTimeline"]));
                        //element.resizeRow(timelineNum,element.getScheduleCount(timelineNum) + 1);
                        // 現在のタイムライン
                        currentNode["nowTimeline"] = timelineNum;
                    }else{
                        //ui.position.top = currentNode["currentTop"];
                    }
                    currentNode["currentTop"] = ui.position.top;
                    currentNode["currentLeft"] = ui.position.left;
                    // テキスト変更
                    element.rewriteBarText($moveNode,scheduleData[sc_key]);
                    return true;
                },
                // 要素の移動が終った後の処理
                stop: function(event, ui) {
                    jQuery(this).data("dragCheck",false);
                    currentNode = null;

                    var node = jQuery(this);
                    var sc_key = node.data("sc_key");
                    var x = node.position().left;
                    var w = node.width();
                    var start = tableStartTime + (Math.floor(x / setting.widthTimeX) * setting.widthTime);
                    var end = tableStartTime + (Math.floor((x + w) / setting.widthTimeX) * setting.widthTime);
                    //var end = start + ((scheduleData[sc_key]["end"] - scheduleData[sc_key]["start"]));

                    scheduleData[sc_key]["start"] = element.formatTimeFull(start+element.calcStringTimeStart(setting.startTime));
                    scheduleData[sc_key]["end"] = element.formatTimeFull(end+element.calcStringTimeStart(setting.startTime));
                    // コールバックがセットされていたら呼出
                    if(setting.change){
                        setting.change(node, scheduleData[sc_key]);
                    }
                }
            });
            $node.resizable({
                handles:'e',
                grid: [ setting.widthTimeX, setting.timeLineY ],
                minWidth:setting.widthTimeX,
                start: function(event, ui){
                    var node = jQuery(this);
                    node.data("resizeCheck",true);
                },
                // 要素の移動が終った後の処理
                stop: function(event, ui){
                    var node = jQuery(this);
                    var sc_key = node.data("sc_key");
                    var x = node.position().left;
                    var w = node.width();
                    var start = tableStartTime + (Math.floor(x / setting.widthTimeX) * setting.widthTime);
                    var end = tableStartTime + (Math.floor((x + w) / setting.widthTimeX) * setting.widthTime);
                    var timelineNum = scheduleData[sc_key]["timeline"];

                    scheduleData[sc_key]["start"] = element.formatTimeFull(start+element.calcStringTimeStart(setting.startTime));
                    scheduleData[sc_key]["end"] = element.formatTimeFull(end+element.calcStringTimeStart(setting.startTime));

                    // 高さ調整
                    element.resetBarPosition(timelineNum);
                    // テキスト変更
                    element.rewriteBarText(node,scheduleData[sc_key]);

                    node.data("resizeCheck",false);
                    // コールバックがセットされていたら呼出
                    if(setting.change){
                        setting.change(node, scheduleData[sc_key]);
                    }
                }
            });
            
            
            return key;
        };
        // スケジュール数の取得
        this.getScheduleCount = function(n){
            var num = 0;
            for(var i in scheduleData){
                if(scheduleData[i]["timeline"] == n){
                    num ++;
                }
            }
            return num;
        };
        // add
        this.addRow = function(timeline,row){
            var title = row["title"];
            var id_vicenda = row["ID"];
            var id = $element.find('.sc_main .timeline').length;

            var html;

            html = '';
            html += '<div class="timeline" style="background:'+row["color"]+'"><span>'+title+'</span></div>';
            var $data = jQuery(html);
            // event call
            if(setting.init_data){
                setting.init_data($data,row);
            }
            $element.find('.sc_data_scroll').append($data);

            html = '';
            html += '<div class="timeline"></div>';
            var $timeline = jQuery(html);
            for(var t=tableStartTime;t<tableEndTime;t+=setting.widthTime){
                var $tl = jQuery('<div class="tl" ></div>');
                $tl.width(setting.widthTimeX - setting.timeBorder +1);

                $tl.data("time",element.formatTimeFull(t+element.calcStringTimeStart(setting.startTime)));
                $tl.data("timeline",id_vicenda);
                $timeline.append($tl);
            }
            // クリックイベント
            if(setting.time_click){
                $timeline.find(".tl").click(function(){
                    setting.time_click(this,jQuery(this).data("time"),jQuery(this).data("timeline"),timelineData[jQuery(this).data("timeline")]);
                });
            }
            $element.find('.sc_main').append($timeline);

            timelineData[timeline] = row;

            if(row["class"] && (row["class"] != "")){
                $element.find('.sc_data .timeline').eq(id).addClass(row["class"]);
                $element.find('.sc_main .timeline').eq(id).addClass(row["class"]);
            }
            // スケジュールタイムライン
            if(row["schedule"]){
                for(var i in row["schedule"]){
                    var bdata = row["schedule"][i];
                    var s = element.calcStringTime(bdata["start"])-element.calcStringTimeStart(setting.startTime);
                    var e = element.calcStringTime(bdata["end"])-element.calcStringTimeStart(setting.startTime);

                    var data = {};
                    data["id"]=bdata["ID"];
                    data["timeline"] = id;
                    data["start"] = s;
                    data["end"] = e;
                    if(bdata["text"]){
                        data["text"] = bdata["text"];
                    }
                    data["data"] = {};
                    if(bdata["data"]){
                        data["data"] = bdata["data"];
                    }
                    if(bdata["png"]){
                        data["png"] = bdata["png"];
                    }
                    if(bdata["pngminori"]){
                        data["pngminori"] = bdata["pngminori"];
                    }
                    element.addScheduleData(data);
                }
            }
            // 高さの調整
            element.resetBarPosition(id);
            $element.find('.sc_main .timeline').eq(id).droppable({
                accept: ".sc_Bar",
                drop: function(ev, ui) {
                    var node = ui.draggable;
                    var sc_key = node.data("sc_key");
                    var nowTimelineNum = scheduleData[sc_key]["timeline"];
                    var timelineNum = $element.find('.sc_main .timeline').index(this);
                    // タイムラインの変更
                    scheduleData[sc_key]["timeline"] = timelineNum;
                    node.appendTo(this);
                    // 高さ調整
                    element.resetBarPosition(nowTimelineNum);
                    element.resetBarPosition(timelineNum);
                }
            });
            // コールバックがセットされていたら呼出
            if(setting.append){
                $element.find('.sc_main .timeline').eq(id).find(".sc_Bar").each(function(){
                    var node = jQuery(this);
                    var sc_key = node.data("sc_key");
                    setting.append(node, scheduleData[sc_key]);
                });
            }
        };
        this.getScheduleData = function(){
            var data = new Array();

            for(var i in timelineData){
                if(typeof timelineData[i] == "undefined") continue;
                var timeline = jQuery.extend(true, {}, timelineData[i]);
                timeline.schedule = new Array();
                data.push(timeline);
            }

            for(var i in scheduleData){
                if(typeof scheduleData[i] == "undefined") continue;
                var schedule = jQuery.extend(true, {}, scheduleData[i]);
                schedule.start = this.formatTime(schedule.start);
                schedule.end = this.formatTime(schedule.end);
                var timelineIndex = schedule.timeline;
                delete schedule.timeline;
                data[timelineIndex].schedule.push(schedule);
            }

            return data;
        };
        // テキストの変更
        this.rewriteBarText = function(node,data){
            var x = node.position().left;
            var w = node.width();
            var start = tableStartTime + (Math.floor(x / setting.widthTimeX) * setting.widthTime);
            var end = tableStartTime + (Math.floor((x + w) / setting.widthTimeX) * setting.widthTime);
            //var end = start + (element.formatTime(data["end"]) - element.formatTime(data["start"]));
            var html = element.formatTime(start)+"-"+element.formatTime(end);
            jQuery(node).find(".time").html(html);
        }
        this.resetBarPosition = function(n){
            // 要素の並び替え
            var $bar_list = $element.find('.sc_main .timeline').eq(n).find(".sc_Bar");
            var codes = [];
            for(var i=0;i<$bar_list.length;i++){
                codes[i] = {code:i,x:jQuery($bar_list[i]).position().left};
            };
            // ソート
            codes.sort(function(a,b){
                if(a["x"] < b["x"]){
                    return -1;
                }else if(a["x"] > b["x"]){
                    return 1;
                }
                return 0;
            });
            var check = [];
            var h = 0;
            var $e1,$e2;
            var c1,c2;
            var s1,e1,s2,e2;
            for(var i=0;i<codes.length;i++){
                c1 = codes[i]["code"];
                $e1 = jQuery($bar_list[c1]);
                for(h=0;h<check.length;h++){
                    var next = false;
                    L: for(var j=0;j<check[h].length;j++){
                        c2 = check[h][j];
                        $e2 = jQuery($bar_list[c2]);

                        s1 = $e1.position().left;
                        e1 = $e1.position().left + $e1.width();
                        s2 = $e2.position().left;
                        e2 = $e2.position().left + $e2.width();
                        if(s1 < e2 && e1 > s2){
                            next = true;
                            continue L;
                        }
                    }
                    if(!next){
                        break;
                    }
                }
                if(!check[h]){
                    check[h] = [];
                }
                $e1.css({top:((h * setting.timeLineY) + setting.timeLinePaddingTop)});
                check[h][check[h].length] = c1;
            }
            // 高さの調整
            this.resizeRow(n,check.length);
        };
        this.resizeRow = function(n,height){
            //var h = Math.max(element.getScheduleCount(n),1);
            var h = Math.max(height,1);
            $element.find('.sc_data .timeline').eq(n).height((h * setting.timeLineY) - setting.timeLineBorder + setting.timeLinePaddingTop + setting.timeLinePaddingBottom);
            $element.find('.sc_main .timeline').eq(n).height((h * setting.timeLineY) - setting.timeLineBorder + setting.timeLinePaddingTop + setting.timeLinePaddingBottom);

            $element.find('.sc_main .timeline').eq(n).find(".sc_bgBar").each(function(){
                jQuery(this).height(jQuery(this).closest(".timeline").height());
            });

            $element.find(".sc_data").height($element.find(".sc_main_box").height());
        }
        // resizeWindow
        this.resizeWindow = function(){
            var sc_width = $element.width();
            var sc_main_width = sc_width - setting.dataWidth - (setting.verticalScrollbar);
            var cell_num = Math.floor((tableEndTime - tableStartTime) / setting.widthTime);
            $element.find(".sc_header_cell").width(setting.dataWidth);
            $element.find(".sc_data,.sc_data_scroll").width(setting.dataWidth);
            $element.find(".sc_header").width(sc_main_width);
            $element.find(".sc_main_box").width(sc_main_width);
            $element.find(".sc_header_scroll").width(setting.widthTimeX*cell_num);
            $element.find(".sc_main_scroll").width(setting.widthTimeX*cell_num);

        };
        // init
        this.init = function(){
            var html = '';
            html += '<div class="sc_menu">'+"\n";
            html += '<div class="sc_header_cell"><span>&nbsp;</span></div>'+"\n";
            html += '<div class="sc_header">'+"\n";
            html += '<div class="sc_header_scroll">'+"\n";
            html += '</div>'+"\n";
            html += '</div>'+"\n";
            html += '<br class="clear" />'+"\n";
            html += '</div>'+"\n";
            html += '<div class="sc_wrapper">'+"\n";
            html += '<div class="sc_data">'+"\n";
            html += '<div class="sc_data_scroll">'+"\n";
            html += '</div>'+"\n";
            html += '</div>'+"\n";
            html += '<div class="sc_main_box">'+"\n";
            html += '<div class="sc_main_scroll">'+"\n";
            html += '<div class="sc_main">'+"\n";
            html += '</div>'+"\n";
            html += '</div>'+"\n";
            html += '</div>'+"\n";
            html += '<br class="clear" />'+"\n";
            html += '</div>'+"\n";

            $element.append(html);

            $element.find(".sc_main_box").scroll(function(){
                $element.find(".sc_data_scroll").css("top", $(this).scrollTop() * -1);
                $element.find(".sc_header_scroll").css("left", $(this).scrollLeft() * -1);

            });
            // add time cell
            var cell_num = Math.floor((tableEndTime - tableStartTime) / setting.widthTime);
            var before_time = -1;
            for(var t=tableStartTime;t<tableEndTime;t+=setting.widthTime){

                if(
                    (before_time < 0) ||
                        (Math.floor(before_time / 3600) != Math.floor(t / 3600))){
                    var html = '';
                    html += '<div class="sc_time">'+element.formatTime(t)+'</div>';
                    var $time = jQuery(html);
                    var cell_num = Math.floor(Number(Math.min((Math.ceil((t + setting.widthTime) / 3600) * 3600),tableEndTime) - t) / setting.widthTime);
                    $time.width((cell_num * setting.widthTimeX) - setting.headTimeBorder+1);
         
                    $element.find(".sc_header_scroll").append($time);

                    before_time = t;
                }
            }

            jQuery(window).resize(function(){
                element.resizeWindow();
            }).trigger("resize");

            // addrow
            for(var i in setting.rows){
                this.addRow(i,setting.rows[i]);
            }
        };
        // 初期化
        this.init();

        this.debug = function(){
            var html = '';
            for(var i in scheduleData){
                html += '<div>';

                html += i+" : ";
                var d = scheduleData[i];
                for(var n in d){
                    var dd = d[n];
                    html += n+" "+dd;
                }

                html += '</div>';
            }
            jQuery(setting.debug).html(html);
        };
        if(setting.debug && setting.debug != ""){
            setInterval(function(){
                element.debug();
            },10);
        }

        return( this );
    };
})(jQuery);
