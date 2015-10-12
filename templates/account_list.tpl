{config_load file="common.conf" section="common_html"}
<html><head>
<title>{$t_html_title}</title>
{#html_header#}
{#common_css#}
{#common_css_navbar#}
{#common_js_upddel#}
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
	<div class="row">
		<div class="col-md-12">
		<a href="account_input.php" class="btn btn-success">新規登録</a>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped table-hover table-condensed">
					<thead>
						<tr class="info">
							<th>アカウント</th>
							<th>名　前</th>
							<th>E-mail</th>
                                                        <th class="text-center">管理者／一般</th>
							<th class="text-center">操作</th>
						</tr>
					</thead>
					<tbody>
						<!-- {section name=accountlst loop=$account} -->
						<tr>
							<td>{$account[accountlst]}</td>
							<td>{$user_name[accountlst]}</td>
							<td>{$mail_address[accountlst]}</td>
                                                        <td class="text-center">
                                                        {if $admin_flg[accountlst] == 1}
                                                                管理者
                                                        {else}
                                                                一般
                                                        {/if}
                                                        </td>
							<td class="text-center">
								<a href="JavaScript:m_upd('{$account[accountlst]}','account_input.php')" class="btn btn-primary btn-sm">編集</a>
								<a href="JavaScript:m_del('{$account[accountlst]}','account_del.php')" class="btn btn-danger btn-sm">削除</a>
							</td>
						</tr>
						<!-- {/section} -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<ul class="pager">
				{if $current_page != 1}
				<li class="previous"><a href="account_list.php?page={$p_before}">&lt;&lt;前のページへ</a></li>
				{/if}
				{if $current_page != $max_page}
				<li class="next"><a href="account_list.php?page={$p_after}">次のページへ&gt;&gt;</a></li>
				{/if}
			</ul>
		</div>
	</div>
</div>
{#common_js#}
</body></html>
