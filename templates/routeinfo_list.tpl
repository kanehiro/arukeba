{config_load file="common.conf" section="common_html"}
<html><head>
<title>{$t_html_title}</title>
{#html_header#}
{#common_css_dtable#}
{#common_css#}
{#common_css_navbar#}
{#common_js_upddel#}
{literal}
<script language="JavaScript">
    function formCf() {
        with (document.route_srch) {
                chk_flg = true;
                /*
                if (){
                        alert("他の検索条件を入力して下さい");
                        return(false);
                }
                */
                submit()
        }
        return(true);
    }
    function formClear() {
        with (document.route_srch) {
            s_routename.value = "";
            s_account.value = "";
            submit()
        }
    }
</script>
{/literal}
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
		<!-- エラーメッセージ -->
		{if array_filter($err_msg)}
		<div class="col-md-offset-1 col-md-7">
			<div class="alert alert-danger">
				{foreach from=$err_msg item=e_msg}
					{if {$e_msg} != ""}
					<li><strong>{$e_msg}</strong></li>
					{/if}
				{/foreach}
			</div>
		</div>
		{/if}
	</div>
	<!-- 検索項目 ここから-->
	<div class="row">
		<div class="well well-sm col-xs-12">
		<form class="form-horizontal" name="route_srch" method="post" action="routeinfo_list.php">
			<fieldset>
			<legend>検索条件</legend>
			<div class="col-xs-12 col-sm-4 col-md-3">
				<div class="form-group">
					<div class="col-xs-4" style="padding-right:0px">
					<label>ルート名</label>
					</div>
					<div class="col-xs-2" style="padding-left:0px; padding-right:0px;">
					</div>
					<div class="col-xs-8" style="padding-left:0px; padding-right:0px;">
					<input type="text" class="form-control" id="s_routename" name="s_routename" placeholder="ルート名で絞り込み" value="{$s_routename}" onChange="this.form.submit()">
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-3">
				<div class="form-group">
					<div class="col-xs-4" style="padding-right:0px">
					<label>歩いた人</label>
					</div>
					<div class="col-xs-2" style="padding-left:0px; padding-right:0px;">
					</div>
					<div class="col-xs-8" style="padding-left:0px; padding-right:0px;">
					<input type="text" class="form-control" id="s_account" name="s_account" placeholder="歩いた人で絞り込み" value="{$s_account}" onChange="this.form.submit()">
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-2 col-md-12 text-right" style="padding-right:30px;">
				<div class="form-group">
					<input type="button" class="btn btn-info" name="btn_clear" onClick="formClear()" value="クリア">
				</div>
			</div>
			</fieldset>
		</form>
		</div>
	</div>
	<!--　検索項目　ここまで　-->
	<div class="row">
		<div class="col-md-12">
			<div class="table">
	            <table id="dtable" class="table table-striped table-condensed table-hover" >
					<thead>
						<tr class="info">
                                                    <th>ID</th>
                                                    <th>ルート名</th>
                                                    <th>備考</th>
                                                    <th>記録日時</th>
                                                    <th>歩いた人</th>
                                                    <th class="text-center">操作</th>
						</tr>
					</thead>
					<tbody>
						<!-- {section name=routelst loop=$id} -->
						<tr>
                                                    <td>{$id[routelst]}</td>
                                                    <td>{$route_name[routelst]}</td>
                                                    <td>{$remarks[routelst]}</td>
                                                    <td>{$startdatetime[routelst]}</td>
                                                    <td>{$account[routelst]}</td>
                                                    <td class="text-center">
                                                        <a href="JavaScript:m_upd('{$id[routelst]}','routeinfo_input.php')" class="btn btn-primary btn-sm">編集</a>
                                                        <a href="JavaScript:m_del('{$id[routelst]}','routeinfo_del.php')" class="btn btn-danger btn-sm">削除</a>
                                                    </td>
						</tr>
						<!-- {/section} -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
 

</div>
{#common_js#}
{#common_js_dtable#}
</body></html>
