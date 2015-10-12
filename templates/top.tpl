{config_load file="common.conf" section="common_html"}
<html><head>
<title>{$t_html_title}</title>
{#html_header#}
{#common_css#}
{#common_css_navbar#}
{literal}
{/literal}
</head><body>
<!-- ナビゲーションバー -->
{#common_navbar_l#}
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
		<h3 class="page-header">{$page_title}</h3>
	</div>
	<!-- メニュー -->
	<div class="row">
		<div class="text-center">
			<div class="btn-group-vertical">
				<a href="routeinfo_list.php" class="btn btn-default btn-lg"> ルート情報管理</a>
				{if $in_user_af == 1}
				<a href="account_list.php" class="btn btn-default btn-lg">ユーザーマスタ保守</a>
				{/if}
			</div>
		</div>
	</div>
</div>
{#common_js#}
</body></html>
