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
			<form class="form-horizontal well" name="user_input" method="post" action="routeinfo_inputsub.php">
				<fieldset>
				<div class="form-group">
					<label for="id" class="col-md-3 control-label">ID{#common_req#}</label>
					<div class="col-md-3">
					{if $mode == 2}
					<input type="text" class="form-control" id="id" name="id" placeholder="ID" value="{$id}" readonly>
					{else}
					<input type="text" class="form-control" id="id" name="id" placeholder="ID" value="{$id}">
					{/if}
					</div>
				</div>
				<div class="form-group">
					<label for="route_name" class="col-md-3 control-label">ルート名{#common_req#}</label>
					<div class="col-md-5">
					<input type="text" class="form-control" id="route_name" name="route_name" placeholder="ルート名" value="{$route_name}">
					</div>
				</div>
				<div class="form-group">
					<label for="remarks" class="col-md-3 control-label">備考</label>
					<div class="col-md-9">
						<input type="text" class="form-control" id="remarks" name="remarks" placeholder="備考" value="{$remarks}">
					</div>
				</div>
                                <div class="form-group">
					<label for="startdatetime" class="col-md-3 control-label">開始日時{#common_req#}</label>
					<div class="col-md-3">
					{if $mode == 2}
					<input type="text" class="form-control" id="startdatetime" name="startdatetime" placeholder="開始日時" value="{$startdatetime}" readonly>
					{else}
					<input type="text" class="form-control" id="startdatetime" name="startdatetime" placeholder="開始日時" value="{$startdatetime}">
					{/if}
					</div>
				</div>
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

				<div class="text-center">
					<input type="submit" class="btn  btn-info" name="btn_check" value="　確　認　">
					<a href="routeinfo_list.php" class="btn btn-default">キャンセル</a>
				</div>
  				</fieldset>
			</form>
		</div>
	</div>
</div>
{#common_js#}
</body></html>
