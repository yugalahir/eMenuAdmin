<table cellpadding="0" cellspacing="0" border="0" class="display groceryCrudTable dataTables_scroll table table-striped table-hover table-bordered dataTable" id="idmytable">
	<thead>
		<tr>
<!--        	<th class="sorting_disabled" role="columnheader" style=" width:50px;">Sr No</th>-->
			<?php foreach($columns as $column){?>
				<th class="sorting_disabled" role="columnheader"><?php echo $column->display_as; ?></th>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<th class='actions' role="columnheader" ><div class="DataTables_sort_wrapper">Options</div></th>
			<?php }?>
		</tr>
	</thead>
	<tbody>
		<?php 
		$srno =1;
		foreach($list as $num_row => $row){ ?>
		<tr id='row-<?php echo $num_row?>'>
<!--        	<td><?php echo $srno++;?></td>-->
			<?php foreach($columns as $column){?>
            	
				<td><?php echo $row->{$column->field_name}?></td>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<td class='actions'>
				<?php
				if(!empty($row->action_urls)){
					foreach($row->action_urls as $action_unique_id => $action_url){
						$action = $actions[$action_unique_id];
				?>
                            <a href="<?php echo $action_url; ?>" class="btn  btn-xs  btn-primary" role="button" title="<?php echo $action->label?>">
<!--							<span class="ui-button-icon-primary ui-icon <?php echo $action->css_class; ?> <?php echo $action_unique_id;?>"></span><span class="ui-button-text">&nbsp;<?php echo $action->label?></span>-->
                                                        <i class="<?php echo $action->css_class; ?>"></i>
                                                </a>
				<?php }
				}
				?>
				<?php if(!$unset_read){?>
					<a href="<?php echo $row->read_url?>" class="btn  btn-xs  btn-success" role="button">
						<i class="fa fa-file-o"></i>
<!--						<span class="ui-button-text">&nbsp;<?php /*echo $this->l('list_view');*/ ?></span>-->
					</a>
				<?php }?>

				<?php if(!$unset_edit){?>
					<a href="<?php echo $row->edit_url?>" class="btn btn-xs btn-info edit_button" role="button">
						<i class="glyphicon glyphicon-edit"></i>
<!--						<span class="ui-button-text">&nbsp;<?php /* echo $this->l('list_edit');*/ ?></span>-->
					</a>
				<?php }?>
				<?php if(!$unset_delete){?>
					<a onclick = "javascript: return delete_row('<?php echo $row->delete_url?>', '<?php echo $num_row?>')"
						href="javascript:void(0)" class="btn  btn-xs  btn-danger delete" role="button">
						<i class="glyphicon glyphicon-trash"></i>
<!--						<span class="ui-button-text">&nbsp;<?php /*echo $this->l('list_delete');*/ ?></span>-->
					</a>
				<?php }?>
			</td>
			<?php }?>
		</tr>
		<?php }?>
	</tbody>
	<tfoot>
<!--		<tr>
        	<th><input type="text" name="sr_no" placeholder="Sr No" class="form-control search_sr_no" style="width:50px;" /></th>
			<?php foreach($columns as $column){?>
				<th><input type="text" name="<?php echo $column->field_name; ?>" placeholder="<?php echo $this->l('list_search').' '.$column->display_as; ?>" class="form-control search_<?php echo $column->field_name; ?>" /></th>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
				<th>
					<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only floatR refresh-data" role="button" data-url="<?php echo $ajax_list_url; ?>">
						<span class="ui-button-icon-primary ui-icon ui-icon-refresh"></span><span class="ui-button-text">&nbsp;</span>
					</button>
					<a href="javascript:void(0)" role="button" class="clear-filtering ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary floatR">
						<span class="ui-button-icon-primary ui-icon ui-icon-arrowrefresh-1-e"></span>
						<span class="ui-button-text"><?php echo $this->l('list_clear_filtering');?></span>
					</a>
				</th>
			<?php }?>
		</tr>-->
	</tfoot>
</table>

