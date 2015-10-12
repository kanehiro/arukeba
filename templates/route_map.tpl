{config_load file="common.conf" section="common_html"}
<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>{$t_html_title}</title>
{#html_header#}
{#common_css_dtable#}
{#common_css#}
{#common_css_navbar#}
{#common_js_upddel#}
{literal}
<script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBxWi5npLlNArcDLyRIBuUuTbzA5wsieqw&sensor=false">
</script>
<script language="JavaScript">
    function m_back(m_url) {
            url = m_url;
            location.href = url;
    }
    function initialize() {
        {/literal}
            var json_obj = {$latlonAry};
        {literal}
        //console.log(JSON.stringify(obj));
        
        var latlng = new google.maps.LatLng(json_obj[0].latitude,json_obj[0].longitude);
        var opts = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"), opts);
        // マーカー、infoWindow、ポリライン作成
        var markers = [] ;
        var infoWindows = [];
        var j = 0;
        var paths =[];
        
        for (var i=0; i<json_obj.length; i++){
            if (i == 0) {
                markers[j] = new google.maps.Marker({
                    map: map,
                    title: "スタート",
                    position: new google.maps.LatLng( json_obj[i].latitude , json_obj[i].longitude ) ,
                    //anchorPoint: new google.maps.Point( 0 , -24 ),
                }) ;
                infoWindows[j] = new google.maps.InfoWindow({
                    content: "スタート",
                }) ;
                infoWindows[j].open(map,markers[j]);
                onMarkerClick(markers[j], j);
                /*
                google.maps.event.addListener(markers[j], 'click', function() {
                    // jを渡せない
                    // alert(j);
                    infoWindows[j].open(map,markers[j]);
                });
                */
                j++;
            }
            if (i == json_obj.length - 1) {
                markers[j] = new google.maps.Marker({
                    map: map,
                    title: "エンド",
                    position: new google.maps.LatLng( json_obj[i].latitude , json_obj[i].longitude ) ,
                    //anchorPoint: new google.maps.Point( 0 , -24 ),
                }) ;
                infoWindows[j] = new google.maps.InfoWindow({
                    content: "エンド",
                }) ;
                infoWindows[j].open(map,markers[j]);
                onMarkerClick(markers[j], j);
                j++;
            }
            if (json_obj[i].point_name.length > 0) {
                markers[j] = new google.maps.Marker({
                    map: map,
                    title: json_obj[i].point_name,
                    position: new google.maps.LatLng( json_obj[i].latitude , json_obj[i].longitude ) ,
                }) ;
                infoWindows[j] = new google.maps.InfoWindow({
                    content:json_obj[i].point_name,
                }) ;
                infoWindows[j].open(map,markers[j]);
                onMarkerClick(markers[j], j);
                j++;
            }
            paths.push( new google.maps.LatLng(json_obj[i].latitude , json_obj[i].longitude));
        } 
        //console.log(paths);
        var polylines = new google.maps.Polyline({
            map: map ,
            strokeWeight : 3,
            strokeColor : "#d36015",
            strokeOpacity : 0.5,
            path: paths,
        }) ;
        function onMarkerClick(marker, idx){
            // idxを保存してくれる
            google.maps.event.addListener(
                marker,
                'click',
                function(event){
                    //alert(idx);
                    infoWindows[idx].open(map,markers[idx]);
                }
            );
        }
          
  }
</script>
<style type="text/css">
    #map_canvas { width:100%; height:100%; }
</style>
{/literal}
</head><body onload="initialize()">
<div class="container">
        <div >
                <div>
                    <a href=route_list.php>一覧へ</a>
                    <label>　コース名：{$routename}</label>		
                </div>
        </div>
       <div class="col-md-12" id="map_canvas">
        </div>

</div>
{#common_js#}
{#common_js_dtable#}
</body></html>