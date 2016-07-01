var basemap = new ol.layer.Tile({
        source: new ol.source.OSM()
      });

var map = new ol.Map({
	layers: [basemap],
	target: 'map',
	view: new ol.View({
		projection: "http://www.opengis.net/gml/srs/epsg.xml#4326",
        center: [-7.5607, 33.3770],
        zoom: 10
	})
});

var sphere = new ol.Sphere(6378137);//the geodesic sphere to compute area of polygons

//the land parcels layer as a geojson layer
var parcelSource=new ol.source.Vector({
	projection : 'EPSG:4326',
	url: 'Maps/Terrains.geojson',
	format: new ol.format.GeoJSON()
});
var parcelLayer=new ol.layer.Vector({
	title: 'Land Parcels',
	source: parcelSource,
	style: new ol.style.Style({
		fill: new ol.style.Fill({
			color: 'rgba(255, 255, 255, 0.2)'
		}),
		stroke: new ol.style.Stroke({
			color: '#737373',
			width: 2
		}),
		image: new ol.style.Circle({
			radius: 7,
			fill: new ol.style.Fill({
				color: '#ffcc33'
			})
		})
	})
});

map.addLayer(parcelLayer);

// Editing Features code --------------------------------------------------

// Edits will be done on an Overlay and then will be saved
var features = new ol.Collection();
var featureOverlay = new ol.layer.Vector({
	source: new ol.source.Vector({features: features}),
	style: new ol.style.Style({
		fill: new ol.style.Fill({
			color: 'rgba(255, 255, 255, 0.2)'
		}),
		stroke: new ol.style.Stroke({
			color: '#ffcc33',
			width: 2
		}),
		image: new ol.style.Circle({
			radius: 7,
			fill: new ol.style.Fill({
				color: '#ffcc33'
			})
		})
	})
});
featureOverlay.setMap(map);
//we add a select interaction to the map so that we can use it later to modify the selected feature
var select = new ol.interaction.Select();
map.addInteraction(select);
var selectedFeature;

var popup = new ol.Overlay.Popup();
map.addOverlay(popup);
var singleClickListener=function(evt) {
	popup.hide();
	popup.setOffset([0, 0]);
	var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {
        	return feature;
    		});
	if (feature) {
		selectedFeature=feature;        
		//getting the center of the polygons to display the popup on its coordinates
		var ext=feature.getGeometry().getExtent();
		var center=ol.extent.getCenter(ext);
		var props = feature.getProperties();
		var superficie=Math.round(Math.abs(sphere.geodesicArea(feature.getGeometry().getLinearRing(0).getCoordinates())));
		var info =  "<form class='form-container'>"
				+"<table>"
					+"<tr>"
						+"<td><div class='form-title'>ID</div></td>"
						+"<td><input id='ID_popup' class='form-field' type='text' value="+props.ID+" /></td>"
						+"<td><div class='form-title'>ID Expropriation</div></td>"
						+"<td><input id='ID_Exp_popup' class='form-field' type='text' value="+props.ID_Expropriation+" /></td>"
					+"</tr>"
					+"<tr>"
						+"<td><div class='form-title'>Géometrie</div></td>"
						+"<td colspan='3'><textarea id='Geometry' class='form-field' cols='50' rows='2'>"+feature.getGeometry().getCoordinates()+"</textarea></td>"
					+"</tr>"
					
					+"<tr>"
						+"<td><div class='form-title'>Symbole</div></td>"
						+"<td><input id='Symbole_popup' class='form-field' type='text' value="+props.Symbole+" /></td>"
						+"<td><div class='form-title'>Num Foncier</div></td>"
						+"<td><input id='Num_Foncier_popup' class='form-field' type='text' value="+props.Num_Foncier+" /></td>"
					+"</tr>"
					+"<tr>"
						+"<td><div class='form-title'>Nom</div></td>"
						+"<td colspan='3'><input id='Nom' class='form-field' type='text' value="+props.Nom+" /></td>"
					+"</tr>"
					+"<tr>"
						+"<td><div class='form-title'>Région</div></td>"
						+"<td colspan='3'><input id='Region' class='form-field' type='text' value="+props.Region+" /></td>"
					+"</tr>"
					+"<tr>"
						+"<td><div class='form-title'>Province</div></td>"
						+"<td colspan='3'><input id='Province' class='form-field' type='text' value="+props.Province+" /></td>"
					+"</tr>"
					+"<tr>"
						+"<td><div class='form-title'>Commune</div></td>"
						+"<td colspan='3'><input id='Commune' class='form-field' type='text' value="+props.Commune+" /></td>"
					+"</tr>"
					+"<tr>"
						+"<td><div class='form-title'>Superficie</div></td>"
						+"<td colspan='3'><input id='Superficie' class='form-field' type='text' value="+superficie+" /></td>"
					+"</tr>"
				+"</table>"
				+"<div class='submit-container'>"
					+"<input class='submit-button' type='submit' value='Sauvegarder' />"
				+"</div>"
			+"</form>";
        // Offset the popup so it points at the middle of the marker not the tip
		popup.setOffset([0, -22]);
		popup.show(center,info);
		map.setView( new ol.View({
			projection: "http://www.opengis.net/gml/srs/epsg.xml#4326",
        	center: [center[0] , center[1]+0.4],
        	zoom: 10
			}));
		}
	$('#Save').click(function(evt){
		evt.preventDefault();
		selectedFeature.set('ID_Expropriation',$('#ID_Exp_popup').val());
		selectedFeature.set('Symbole',$('#Symbole_popup').val());
		selectedFeature.set('Nom',$('#Nom_popup').val());
		selectedFeature.set('Num_Foncier',$('#Num_Foncier_popup').val());
		selectedFeature.set('Commune',$('#Commune_popup').val());
		selectedFeature.set('Province',$('#Province_popup').val());
		selectedFeature.set('Region',$('#Region_popup').val());
		var swappedFeature = selectedFeature;
		/*swappedFeature.getGeometry().applyTransform(function (coords, coords2, stride) {
    		for (var i=0;i<coords.length;i+=stride) {
        		var y = coords[i];
        		var x = coords[i+1];
        		coords[i] = x;
        		coords[i+1] = y;
    		}
		});
		var node = formatwfs.writeTransaction(null, [swappedFeature], null, {
			featureNS: "Afriquia_Gaz",//Namespace in Geoserver
			featureType: "Microzones"//the layer's name
		});
		var str=new XMLSerializer().serializeToString(node);
		var data=str.replace("feature:Microzones","Afriquia_Gaz:Microzones");
		//alert(data);
		//an AJAX call to store the data
		$.ajax({
			type: "POST",
			url: "http://localhost:8080/geoserver/wfs",
			data: data,
			contentType: 'text/xml',
			success: function(data) {
				console.log("Attributes successfully modified");
			},
			error: function(e) {
				var errorMsg = e? (e.status + ' ' + e.statusText) : "";
				alert('Error saving this feature to GeoServer.<br><br>'+ errorMsg);
			},
			context: this
		});*/
		//location.reload();
	});
}
var key=map.on('singleclick', singleClickListener);

//Drawing code starts here

var draw; // global so we can remove it later
var formatwfs = new ol.format.WFS();// here we declare the format WFS to be used later on the transaction
draw = new ol.interaction.Draw({
       		features: features, // we set the newly drawn feature on the overlay declared previously
       		type: /** @type {ol.geom.GeometryType} */ ('Polygon') // Type of the feature in our case it's polygon
       		});
// when a new feature has been drawn...
draw.on('drawend', function(event) {
	var formatwkt = new ol.format.WKT();
	var wkt = formatwkt.writeGeometry(event.feature.getGeometry());
	alert(wkt+"  "+Math.round(Math.abs(sphere.geodesicArea(event.feature.getGeometry().getLinearRing(0).getCoordinates()))));
	//var feature = event.feature;// this variable feature will serve to store the attributes of the new zone
	//feature.set('superficie',Math.abs(sphere.geodesicArea(feature.getGeometry().getLinearRing(0).getCoordinates())));
	/*var node = formatwfs.writeTransaction([feature], null, null, {//here we make the wfs-t call to insert the feature
		featureNS: "Afriquia_Gaz",//Namespace in Geoserver
		featureType: "Afriquia_Gaz:Microzones"//the layer's name
	});
	
	//an AJAX call to store the data
	$.ajax({
		type: "POST",
		url: "http://localhost:8080/geoserver/wfs",
		data: new XMLSerializer().serializeToString(node),
		contentType: 'text/xml',
		success: function(data) {
			console.log("feature successfully added");
		},
		error: function(e) {
			var errorMsg = e? (e.status + ' ' + e.statusText) : "";
			alert('Error saving this feature to GeoServer.<br><br>'
			+ errorMsg);
		},
		context: this
	});*/
	//and voila
	map.removeInteraction(draw);//Here we disable drawing
	key=map.on('singleclick',singleClickListener);//and re-enable the singleClickListener to display the popup form
});

$('#Draw_otf').click( function(){
	$(this).toggleClass("active");
	if(this.className=="active"){
		map.unByKey(key);	
		map.removeInteraction(modify);// we disable the modify interaction so there can be no conflicts between events
		map.addInteraction(draw);//not to forget to add the interaction to the map
	}
	else{
		map.removeInteraction(draw);//Here we disable drawing
		key=map.on('singleclick',singleClickListener);//and re-enable the singleClickListener to display the popup form
	}
	});


// Drawing code ends here

//Modification code starts here

//we add the modify interaction to the selected feature
var modify = new ol.interaction.Modify({
	features: select.getFeatures(),
        // the SHIFT key must be pressed to delete vertices, so
        // that new vertices can be drawn at the same position
        // of existing vertices
        deleteCondition: function(event) {
        	return ol.events.condition.shiftKeyOnly(event) &&
              	ol.events.condition.singleClick(event);
        	}
      	});


$('#Modify').click( function(){
	$(this).toggleClass("active");
	if(this.className=="active"){
		map.unByKey(key);
		map.removeInteraction(draw);
		map.addInteraction(modify);
		var dirty = {};
		select.getFeatures().on('add', function(e) {
			e.element.on('change', function(e) {
				dirty[e.target.getId()] = true;
			});
		});
		var clone;
		select.getFeatures().on('remove', function(e) {
			var f = e.element;
			if (dirty[f.getId()]){
				delete dirty[f.getId()];
				featureProperties = f.getProperties();
				delete featureProperties.boundedBy;
				clone = new ol.Feature(featureProperties);
				clone.setId(f.getId());
				var formatwkt = new ol.format.WKT();
				var wkt = formatwkt.writeGeometry(clone.getGeometry());
				alert(wkt);
				/*var swappedFeature = clone;
				swappedFeature.getGeometry().applyTransform(function (coords, coords2, stride) {
					for (var i=0;i<coords.length;i+=stride) {
						var y = coords[i];
						var x = coords[i+1];
						coords[i] = x;
						coords[i+1] = y;
					}
				});
				var node = formatwfs.writeTransaction(null, [clone], null, {//here we make the wfs-t call to insert the feature	
					//srsName:"CRS:84",				
					featureNS: "Afriquia_Gaz",//Namespace in Geoserver
					featureType: "Microzones"//the layer's name
				});
				var str=new XMLSerializer().serializeToString(node);
				var data=str.replace("feature:Microzones","Afriquia_Gaz:Microzones");
				//alert(data);
				//an AJAX call to store the data
				$.ajax({
					type: "POST",
					url: "http://localhost:8080/geoserver/wfs",
					data: data,
					contentType: 'text/xml',
					success: function(data) {
						console.log("Geometry successfully modified");
					},
					error: function(e) {
						var errorMsg = e? (e.status + ' ' + e.statusText) : "";
						alert('Error saving this feature to GeoServer.<br><br>'+ errorMsg);
					},
					context: this
				});*/
				//location.reload();
			}
		});
	}
	else{
		map.removeInteraction(modify);//Here we disable modifying
		key=map.on('singleclick',singleClickListener);//and re-enable the singleClickListener to display the popup form
	}
	
});

//Delete Feature code starts here
$('#Delete').click( function(){
	/*var node = formatwfs.writeTransaction(null, null, [selectedFeature], {//here we make the wfs-t call to insert the feature	
			//srsName:"CRS:84",				
			featureNS: "Afriquia_Gaz",//Namespace in Geoserver
			featureType: "Microzones"//the layer's name
		});
		var str=new XMLSerializer().serializeToString(node);
		var data=str.replace("feature:Microzones","Afriquia_Gaz:Microzones");*/
		//alert(data);
		//an AJAX call to store the data
		/*$.ajax({
			type: "POST",
			url: "http://localhost:8080/geoserver/wfs",
			data: data,
			contentType: 'text/xml',
			success: function(data) {
				console.log("Microzone successfully deleted");
			},
			error: function(e) {
				var errorMsg = e? (e.status + ' ' + e.statusText) : "";
				alert('Error deleting this feature from GeoServer.<br><br>'+ errorMsg);
			},
			context: this
		});*/
		//location.reload();
});
// Delete code ends here
// Editing code ends here

//Toggles the search form
$('#Open_search').click( function(){
	$(this).toggleClass("active");
	$('#SearchDiv').toggle('slow', function() {
    // Animation complete.
  });
});

//toggles the insert form
$('#Draw_XY').click( function(){
	$(this).toggleClass("active");
	$('#InsertDiv').toggle('slow', function() {
    // Animation complete.
  });
});

//Insert a feature by its coordinates ( code starts here )

$('#Insert').click( function(event){
	event.preventDefault();
	var coords=$('#Geometry').val();
	var res;
	var points = [];
	res=coords.split(",");
	for (var i = 0; i < res.length; i +=2) {
		points.push([parseFloat(res[i]),parseFloat(res[i+1])]);
	}
	var feature= new ol.Feature({
		geometry: new ol.geom.Polygon([points])
	});
	parcelLayer.getSource().addFeature(feature);
	
});

//Insert code ends here

//Search features by ID starts here
$('#Search').click( function(evt){
	parcelSource.forEachFeature(function(feature) {
		if(feature.get('ID')==$('#ID_Search').val()){
			select.getFeatures().clear();
			select.getFeatures().push(feature);
			//getting the center of the polygons to display the popup on its coordinates
		/*var ext=feature.getGeometry().getExtent();
		var center=ol.extent.getCenter(ext);
        var props = feature.getProperties();
        var info =  "<form class='search-form-container'>"
			+"<table>"
				+"<tr>"
					+"<td><div class='form-title'>ID</div></td>"
					+"<td><input id='ID' class='form-field' type='text' value="+props.ID+" /></td>"
				+"</tr>"
				+"<tr>"
						+"<td><div class='form-title'>Géometrie</div></td>"
						+"<td><textarea id='Geometry' class='form-field' cols='40' rows='5'  name='firstname'></textarea></td>"
				+"</tr>"
				+"<tr>"
					+"<td><div class='form-title'>Zone</div></td>"
					+"<td><input id='Microzone' class='form-field' type='text' value="+props.microzone+" /></td>"
				+"</tr>"
				+"<tr>"
					+"<td><div class='form-title'>Arrondissement</div></td>"
					+"<td><input id='Arrondissement' class='form-field' type='text' value="+props.arrondissement+" /></td>"
				+"</tr>"
				+"<tr>"
					+"<td><div class='form-title'>Prefecture</div></td>"
					+"<td><input id='Prefecture' class='form-field' type='text' value="+props.prefecture+" /></td>"
				+"</tr>"
				+"<tr>"
					+"<td><div class='form-title'>Population</div></td>"
					+"<td><input id='Population' class='form-field' type='text' value="+props.population+" /></td>"
				+"</tr>"
				+"<tr>"
					+"<td><div class='form-title'>Superficie</div></td>"
					+"<td><input id='Superficie' class='form-field' type='text' value="+props.superficie+" /></td>"
				+"</tr>"
			+"</table>"
			+"<div class='submit-container'>"
				+"<input id='Save' class='submit-button' type='button' value='Save' />"
			+"</div>"
		+"</form>";
        // Offset the popup so it points at the middle of the marker not the tip
        popup.setOffset([0, -22]);
        popup.show(center,info);*/
		
		}
	});
	var extent = select.getFeatures().item(0).getGeometry().getExtent();
	features.forEach(function(feature){ ol.extent.extend(extent,feature.getGeometry().getExtent())});
	map.getView().fit(extent, map.getSize());
});
//Search code ends here
// Hover Interaction code starts here
hoverInteraction = new ol.interaction.Select({
	condition: ol.events.condition.pointerMove,
	layers:[parcelLayer]	//Setting layers to be hovered
	});
map.addInteraction(hoverInteraction);

// Hover interaction ends here
