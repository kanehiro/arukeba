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
	</div>
	<!-- ページタイトル -->
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h3>{$page_title}</h3>
			</div>
		</div>
	</div>
	<!-- エラーメッセージ -->
	<div class="row">
		<div class="col-md-offset-2 col-md-7">
			<div class="alert alert-danger">
				<strong>
				「 {$account} : {$user_name} 」 を削除します。 よろしいですか？
				</strong>
			</div>
		</div>
	</div>
	<!-- 項目 -->
	<div class="row">
		<div class="col-md-offset-2 col-md-7">
			<form class="form-horizontal well" name="user_del" method="post" action="account_del.php">
				<fieldset>
				<div class="form-group">
					<label for="account" class="col-md-3 control-label">アカウント</label>
					<p class="col-md-9 form-control-static">{$account}</p>
				</div>
				<div class="form-group">
					<label for="user_name" class="col-md-3 control-label">名　前</label>
					<p class="col-md-9 form-control-static">{$user_name}</p>
				</div>
				<div class="text-center">
					<input type="submit" class="btn  btn-danger" name="btn_del" value="　削　除　">
					<a href="account_list.php" class="btn btn-default">キャンセル</a>
				</div>
  				</fieldset>
			</form>
		</div>
	</div>
</div>
{#common_js#}
</body></html>
