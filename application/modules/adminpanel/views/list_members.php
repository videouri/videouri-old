<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
    <h1 class="page-title"><?php print $this->lang->line('list_members_title'); ?></h1>

    <?php $this->load->view('generic/flash_error'); ?>

    <?php print form_open('adminpanel/list_members/index/username/asc/post/0') ."\r\n"; ?>

<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#search_wrapper">
    collapse search
</button>

    <div id="search_wrapper" class="container-fluid collapse">

        <h2>
            <?php print $this->lang->line('search_member'); ?>
        </h2>

        <div class="row">

            <div class="col-sm-3">
				<div class="form-group">
					<label for="username"><?php print $this->lang->line('username'); ?></label>
					<input type="text" name="username" id="username" class="form-control">
				</div>
            </div>

            <div class="col-sm-3">
				<div class="form-group">
					<label for="first_name"><?php print $this->lang->line('first_name'); ?></label>
					<input type="text" name="first_name" id="first_name" class="form-control">
				</div>
            </div>

            <div class="col-sm-3">
				<div class="form-group">
					<label for="last_name"><?php print $this->lang->line('last_name'); ?></label>
					<input type="text" name="last_name" id="last_name" class="form-control">
				</div>
            </div>

            <div class="col-sm-3">
				<div class="form-group">
					<label for="email"><?php print $this->lang->line('email_address'); ?></label>
					<input type="text" name="email" id="email" class="form-control">
				</div>
            </div>


            <?php print form_close() ."\r\n"; ?>

        </div>
		
		<div class="row">
			<div class="col-xs-12 clearfix">
                <input type="submit" name="member_search_submit" id="member_search_submit" value="<?php print $this->lang->line('search_member'); ?>" class="btn btn-primary btn-loading">
				<span class="loading"><img src="<?php print base_url(); ?>images/loaderB16.gif" alt=""></span>
            </div>
		</div>
    </div>

	<div class="row margin-top-30">
		<div class="col-xs-12">
		
			<p class="label label-info">
				<?php print "Total rows: ". $total_rows; ?>
			</p>

			<?php if (isset($members)) { ?>

			<?php print $this->pagination->create_links(); ?>

			<?php print form_open('adminpanel/list_members/mass_action/'. $offset .'/'. $order_by .'/'. $sort_order .'/'. $search, 'id="mass_action_form"') ."\r\n"; ?>

			<p class="mass_selection_wrapper">
				<label>With selected: </label>
				<input type="submit" name="delete" id="delete" value="Delete" class="bootbox btn btn-danger" title="Are you sure you want to delete those members?">
				<input type="submit" name="ban" id="ban" value="Ban" class=" btn btn-warning" title="Are you sure you want to ban those members?">
				<input type="submit" name="unban" id="unban" value="Unban" class="bootbox btn btn-success" title="Are you sure you want to unban those members?">
				<input type="submit" name="activate" id="activate" value="Activate" class="bootbox btn btn-success" title="Are you sure you want to activate those members?">
				<input type="submit" name="deactivate" id="deactivate" value="Deactivate" class="bootbox btn btn-warning" title="Are you sure you want to deactivate those members?">
			</p>

			<table class="table table-hover">
				<thead>
				<tr>
					<th class="list_button"><input type="checkbox" class="select_checkboxes"></th>
					<th class="list_button"><a href="<?php print base_url() ."adminpanel/list_members/index/active/". ($order_by == "active" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>" class="<?php print ($order_by == "active" ? ($sort_order == "asc" ? "glyphicon glyphicon-arrow-up" : "glyphicon glyphicon-arrow-down" ) : ""); ?>"><img src="<?php print base_url(); ?>images/application_form_add.png" title="active"></a></th>
					<th class="list_button"><a href="<?php print base_url() ."adminpanel/list_members/index/banned/". ($order_by == "banned" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>" class="<?php print ($order_by == "banned" ? ($sort_order == "asc" ? "glyphicon glyphicon-arrow-up" : "glyphicon glyphicon-arrow-down" ) : ""); ?>"><img src="<?php print base_url(); ?>images/lock_open.png" title="banned"></a></th>
					<th class="list_button"><a href="<?php print base_url() ."adminpanel/list_members/index/role_id/". ($order_by == "role_id" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>" class="<?php print ($order_by == "role_id" ? ($sort_order == "asc" ? "glyphicon glyphicon-arrow-up" : "glyphicon glyphicon-arrow-down" ) : ""); ?>"><img src="<?php print base_url(); ?>images/medal_gold_add.png" title="role"></a></a></th>
					<th><a href="<?php print base_url() ."adminpanel/list_members/index/username/". ($order_by == "username" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "username" ? ($sort_order == "asc" ? "glyphicon glyphicon-arrow-up" : "glyphicon glyphicon-arrow-down" ) : ""); ?>"></i> username</a></th>
					<th><a href="<?php print base_url() ."adminpanel/list_members/index/email/". ($order_by == "email" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "email" ? ($sort_order == "asc" ? "glyphicon glyphicon-arrow-up" : "glyphicon glyphicon-arrow-down" ) : ""); ?>"></i> email</a></th>
					<th><a href="<?php print base_url() ."adminpanel/list_members/index/first_name/". ($order_by == "first_name" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "first_name" ? ($sort_order == "asc" ? "glyphicon glyphicon-arrow-up" : "glyphicon glyphicon-arrow-down" ) : ""); ?>"></i> first name</a></th>
					<th><a href="<?php print base_url() ."adminpanel/list_members/index/last_name/". ($order_by == "last_name" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "last_name" ? ($sort_order == "asc" ? "glyphicon glyphicon-arrow-up" : "glyphicon glyphicon-arrow-down" ) : ""); ?>"></i> last name</a></th>
					<th><a href="<?php print base_url() ."adminpanel/list_members/index/last_login/". ($order_by == "last_login" ? ($sort_order == "asc" ? "desc" : "asc" ) : "asc") ."/". $search ."/0"; ?>"><i class="<?php print ($order_by == "last_login" ? ($sort_order == "asc" ? "glyphicon glyphicon-arrow-up" : "glyphicon glyphicon-arrow-down" ) : ""); ?>"></i> last login</a></th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($members->result() as $member):
				?>
				<tr>
					<td class="list_button"><?php print ($member->username != ADMINISTRATOR ? '<input type="checkbox" name="mass[]" value="'. $member->id .'" class="list_members_checkbox">' : ''); ?></td>
					<td><a href="<?php print site_url('adminpanel/list_members/toggle_active/'. $member->id ."/". $member->username ."/". $offset .'/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $member->active) ."\" class=\"message_cleanup ". ($member->active == true ? "is_active" : "not_active"); ?>" title="<?php print ($member->active == true ? "de" : ""); ?>activate account"></a></td>
					<td><a href="<?php print site_url('adminpanel/list_members/toggle_ban/'. $member->id ."/". $member->username ."/". $offset .'/'. $order_by .'/'. $sort_order .'/'. $search .'/'. $member->banned) ."\" class=\"message_cleanup ". ($member->banned == true ? "banned" : "not_banned"); ?>" title="<?php print ($member->banned == true ? "un" : ""); ?>ban account"></a></td>
					<td><a href="<?php print site_url(substr($member->role_name, 0, 1) == "a" ? "adminpanel/list_members/demote_member/" : "adminpanel/list_members/promote_member/") . "/". $member->id ."/". $member->username ."/". $offset .'/'. $order_by .'/'. $sort_order .'/'. $search; ?>" class="message_cleanup <?php print (strtolower(substr($member->role_name, 0, 1)) == "a" ? "demote" : "promote"); ?>"><?php print ucfirst(substr($member->role_name, 0, 1)); ?></a></td>
					<td><a href="<?php print base_url(); ?>adminpanel/member_detail/<?php print $member->id; ?>"><?php print (isset($member->username) ? $member->username : "OAuth unfinished"); ?></a></td>
					<td><?php print $member->email; ?></td>
					<td><?php print $member->first_name; ?></td>
					<td><?php print $member->last_name; ?></td>
					<td><?php print $member->last_login; ?></td>
				</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

				<p class="mass_selection_wrapper">
					<label>With selected: </label>
					<input type="submit" name="delete" id="delete" value="Delete" class="bootbox btn btn-danger" title="Are you sure you want to delete those members?">
					<input type="submit" name="ban" id="ban" value="Ban" class="bootbox btn btn-warning" title="Are you sure you want to ban those members?">
					<input type="submit" name="unban" id="unban" value="Unban" class="bootbox btn btn-success" title="Are you sure you want to unban those members?">
					<input type="submit" name="activate" id="activate" value="Activate" class="bootbox btn btn-success" title="Are you sure you want to activate those members?">
					<input type="submit" name="deactivate" id="deactivate" value="Deactivate" class="bootbox btn btn-warning" title="Are you sure you want to deactivate those members?">
				</p>

			<input type="hidden" name="mass_action" id="mass_action" value="">

			<?php print form_close() ."\r\n"; ?>

			<?php print $this->pagination->create_links(); ?>

			<?php }else{ ?>
				<p>No results found.</p>
			<?php } ?>

		</div>
	</div>


