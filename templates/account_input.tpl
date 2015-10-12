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
	{if array_filter($err_msg)}
	<div class="row">
		<div class="col-md-offset-2 col-md-7">
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
	{#common_req_note#}
	<div class="row">
		<div class="col-md-offset-2 col-md-7">
			<form class="form-horizontal well" name="user_input" method="post" action="account_inputsub.php">
				<fieldset>
				<div class="form-group">
					<label for="account" class="col-md-3 control-label">アカウント{#common_req#}</label>
					<div class="col-md-3">
					{if $mode == 2}
					<input type="text" class="form-control" id="account" name="account" placeholder="アカウント" value="{$account}" readonly>
					{else}
					<input type="text" class="form-control" id="account" name="account" placeholder="アカウント" value="{$account}">
					{/if}
					</div>
				</div>
				<div class="form-group">
					<label for="user_name" class="col-md-3 control-label">名　前{#common_req#}</label>
					<div class="col-md-5">
					<input type="text" class="form-control" id="user_name" name="user_name" placeholder="名　前" value="{$user_name}">
					</div>
				</div>
				<div class="form-group">
					<label for="mail_address" class="col-md-3 control-label">E-mail</label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="mail_address" name="mail_address" placeholder="E-mail" value="{$mail_address}">
					</div>
				</div>
                                <div class="form-group">
					<label for="admin_flg" class="col-md-3 control-label">管理者/一般{#common_req#}</label>
					<div class="col-md-9">
						<label class="radio-inline">
							{if $admin_flg == 1}
							<input type="radio" name="admin_flg" id="admin_flg1" value="1" checked="">
							{else}
							<input type="radio" name="admin_flg" id="admin_flg1" value="1">
							{/if}
							管理者
						</label>
						<label class="radio-inline">
							{if $admin_flg == 0 || $admin_flg == ""}
							<input type="radio" name="admin_flg" id="admin_flg0" value="0" checked="">
							{else}
							<input type="radio" name="admin_flg" id="admin_flg0" value="0">
							{/if}
							一般
						</label>
					</div>
				</div>

				<div class="text-center">
					<input type="submit" class="btn  btn-info" name="btn_check" value="　確　認　">
					<a href="account_list.php" class="btn btn-default">キャンセル</a>
				</div>
  				</fieldset>
			</form>
		</div>
	</div>
</div>
{#common_js#}
</body></html>
