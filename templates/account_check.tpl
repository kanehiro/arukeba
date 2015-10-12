{config_load file="common.conf" section="common_html"}
<html><head>
<title>{$t_html_title}</title>
{#html_header#}
{#common_css#}
{#common_css_navbar#}
</head><body>
<div class="container">
    	<div class="row">
		<!-- パンくずリスト -->
		<ol class="breadcrumb">
			{section name=b_crumb loop=$a_breadcrumb}
			<li><a href={$a_breadcrumb[b_crumb].p_url}>{$a_breadcrumb[b_crumb].p_name}</a></li>
			{/section}
			<li class="active">{$page_title}</li>
		</ol>
	</div>	<!-- ページタイトル -->
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h3>{$page_title}</h3>
			</div>
		</div>
	</div>
	<!-- 項目 -->
	<br>
	<div class="row">
		<div class="col-md-offset-2 col-md-7">
			<form class="form-horizontal well" name="user_check" method="post" action="account_inputsub.php">
				<fieldset>
				<div class="form-group">
					<label for="user_id" class="col-md-3 control-label">アカウント</label>
					<p class="col-md-9 form-control-static">{$account}</p>
				</div>
				<div class="form-group">
					<label for="passwd" class="col-md-3 control-label">パスワード</label>
                                        <p class="col-md-9 form-control-static">{$passwd}</p>
				</div>
				<div class="form-group">
					<label for="user_name" class="col-md-3 control-label">名　前</label>
					<p class="col-md-9 form-control-static">{$user_name}</p>
				</div>
				<div class="form-group">
					<label for="mail_address" class="col-md-3 control-label">E-mail</label>
					<p class="col-md-9 form-control-static">{$mail_address}</p>
				</div>
                                <div class="form-group">
					<label for="admin_flg" class="col-md-3 control-label">管理者/一般</label>
					{if $admin_flg == 0}
					<p class="col-md-9 form-control-static">一般</p>
					{else}
					<p class="col-md-9 form-control-static">管理者</p>
					{/if}
				</div>

				<div class="text-center">
					<input class="btn  btn-primary" type="submit" name="btn_input" value="　登　録　">
					<input class="btn  btn-default" type="submit" name="btn_syusei" value="　修　正　">
				</div>
  				</fieldset>
			</form>
		</div>
	</div>
</div>
{#common_js#}
</body></html>
