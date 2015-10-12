{config_load file="common.conf" section="common_html"}
<html><head>
<title>{$t_html_title}</title>
{#html_header#}
{#common_css_login#}
{#common_css_navbar#}
</head><body>
<!-- ナビゲーションバー -->
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">ルート情報管理</a>
		</div>
	</div>
</nav>

<div class="container">
	<!-- エラーメッセージ -->
	{if array_filter($err_msg)}
	<div class="row">
		<div class="col-sm-offset-3 col-sm-6 col-xs-12">
			<div class="alert alert-danger">
				{foreach from=$err_msg item=e_msg}
					{if {$e_msg} != ""}
					<li><strong>{$e_msg}</strong></li>
					{/if}
				{/foreach}
			</div>
		</div>
	</div>
	{/if}
    <div class="row">
		<div class="col-sm-offset-4 col-sm-4 col-xs-12">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title text-center">ログイン</h3>
				</div>
				<div class="panel-body text-center">
					<form role="form" name="login" method="post" action="login.php">
					<fieldset>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="ユーザーID" name="account" autofocus="">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="パスワード" name="passwd" value="">
					</div>
						<button type="submit" name="s_login" class="btn btn-primary" onClick="return formcflogin()">
						ログイン <span class="glyphicon glyphicon-log-in"></span></button>
					</fieldset>
					</form>
				</div>
			</div>
		</div>
	<div>
</div>
{#common_js#}
</body></html>