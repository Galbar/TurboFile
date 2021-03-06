<!DOCTYPE html>
<html ng-app="TurboFileApp" ng-controller="TurboFileCtrl">
<head>
	<base href="/">
	<title>{{$location.path()}}</title>
	<link rel="stylesheet" type="text/css" href="/_turbofile/css/app.css">
	<link rel="stylesheet" type="text/css" href="/_turbofile/css/theme3.css">
	<link rel="stylesheet" type="text/css" href="/_turbofile/css/animations.css">
	<link rel="stylesheet" type="text/css" href="/_turbofile/css/bootstrap.min.css">
	<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?autoload=true&amp;skin=sons-of-obsidian" defer="defer"></script>
	<script src="https://google-code-prettify.googlecode.com/svn/trunk/src/prettify.js" defer="defer"></script>
</head>
<body ng-class="{animate: animate}">
	<div class="header_bar">
		<div id="user">
<?php
	$username = Auth::getUsername();
	if($username == '')
		echo '<a reload="true" href="'.htmlspecialchars(Auth::getLoginUrl()).'">Log in</a>';
	else
		echo 'Hello, '.htmlspecialchars($username).'! <a reload="true" href="'.htmlspecialchars(Auth::getLogoutUrl()).'">Log out</a>';
?>
		</div>
		<div id="logo"></div>
	</div>
	<div class="panels">
		<div class="panel"
		     ng-repeat="panel in panels"
		     ng-class="{
			     	hasnext: !$last,
			     	panel_dir: panel.type=='dir',
			     	panel_file: panel.type=='file',
			     }">
			<div class="panel_inner"
			     ng-class="{
			     	hasnext: !$last,
			     	panel_dir: panel.type=='dir',
			     	panel_file: panel.type=='file',
			     }"
			     ng-style="{transform: 'translateX('+calcLeft($index)+'px)', '-webkit-transform': 'translateX('+calcLeft($index)+'px)'}"
			     ng-switch="panel.type">
				<div ng-switch-when="dir">
					<a class="header" href="{{panel.path}}" reload="panel.reload" title="{{panel.name}}/">
						{{panel.name}}/
					</a>
					<a class="file"
					   ng-repeat="file in panel.files"
					   href="{{file.link}}"
					   ng-class="{selected: file.name==panels[$parent.$index+1].name}"
					   reload="file.reload"
					   title="{{file.name}}{{file.type=='dir'?'/':''}}">
						<i class="icon glyphicon glyphicon-{{file.type=='dir'?'folder-open':'file'}}"></i>{{file.name}}{{file.type=='dir'?'/':''}}
					</a>
				</div>
				<div ng-switch-when="nope">
					<a class="header" href="{{panel.path}}" reload="panel.reload">
						NOPE!
					</a>
					Sorry, you don't have permission to view this. Please
					<a href="{{panel.path}}" reload="true">
						login!
					</a>
				</div>
				<div ng-switch-when="file" class="h100">
					<a class="header" href="{{panel.path}}" reload="true">
						{{panel.name}}
					</a>
					<div ng-switch on="panel.filetype" class="fileview file_{{panel.filetype}}">
						<a ng-switch-when="image" href="{{panel.path}}" reload="true">
							<img ng-src="{{panel.path}}">
						</a>

						<pre ng-switch-when="text" class="textview prettyprint linenums">{{panel.text}}</pre>

						<audio ng-switch-when="audio" controls autoplay>
							<source ng-src="{{panel.path}}" type="{{panel.mimetype}}">
							Your browser does not support the audio element.
						</audio>

						<video ng-switch-when="video" autoplay controls>
							<source ng-src="{{panel.path}}" type="{{panel.mimetype}}">
							Your browser does not support the video element.
						</video>

						<div ng-switch-when="opendocument.text" ng-bind-html="panel.text | unsafe" class="odtview"></div>

						<iframe ng-switch-when="object" frameborder="0" src="{{panel.path}}"></iframe>

						<div ng-switch-default>
							??? {{panel.filetype}}
						</div>
					</ng-switch>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="/_turbofile/js/angular.min.js"></script>
	<script type="text/javascript" src="/_turbofile/js/angular-animate.min.js"></script>
	<script type="text/javascript" src="/_turbofile/js/angular-sanitize.min.js"></script>
	<script type="text/javascript" src="/_turbofile/js/turbofile.js"></script>
</body>
</html>
