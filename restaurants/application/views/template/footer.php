
</section>
 <?php
 
 if($this->session->userdata('message')!="")
 {
 ?>
 <div aria-hidden="true"  aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="messageBox" class="modal fade">
              <div class="modal-dialog ">
                  <div class="modal-content ">
<!--                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"><?php echo $this->session->userdata('messagetype') ?></h4>
                      </div>-->
                      <div class="modal-body">
                          <p class="alert-<?php echo $this->session->userdata('messagetype') ?>"><?php echo $this->session->userdata('message') ?></p>
                          

                      </div>
                     
                  </div>
              </div>
          </div>
<a data-toggle="modal" id="show_message"  href="#messageBox" style=" visibility: hidden;" >_</a>

<?php
    $this->session->unset_userdata('message');
    $this->session->unset_userdata('messagetype');
 }
?>
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.nicescroll.js"></script>

<!-common script init for all pages->
<script src="<?php echo base_url();?>assets/js/scripts.js"></script>


<!--dynamic table-->
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/js/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/data-tables/DT_bootstrap.js"></script>
<!--common script init for all pages-->


<!--dynamic table initialization -->
<script src="<?php echo base_url();?>assets/js/dynamic_table_init.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

</body>
</html>
