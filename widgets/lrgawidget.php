<!-- HTML Template files -->
<div id="lrgawidget_wrap" class="wrap">
<h1><?php echo __('Dashboard'); ?></h1>

<div class="lrga_bs" >

<div id="lrgawidget" class="lrga_bs lrgawidget">

<div class="box box-primary" >
  <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-bar-chart"></i> Google Analytics</h3>
    <div class="box-tools pull-right">
		<span id="lrgawidget_loading"></span>
		<span id="lrgawidget_mode" class="label label-success"></span>
		<button type="button" class="btn btn-box-tool" id="lrgawidget_daterange_label">
		    <i class="fa fa-calendar"></i>
			<span id="lrgawidget_reportrange"></span>
		</button>

		 <span id="lrgawidget_remove" data-widget="home-widget-remove"><i class="fa fa-times"></i></span>
    </div>
  </div>
  <div id="lrgawidget_body" class="box-body">
	<div class="nav-tabs-custom" id="lrgawidget_main">
		<ul class="nav nav-tabs">
		<?php if (in_array("lrgawidget_perm_admin",$globalWidgetPermissions)){  ?>
			<li><a data-toggle="tab" href="#lrgawidget_settings_tab"><i class="fa fa-cog fa-fw"></i><span class="hidden-xs hidden-sm"> Settings</span></a></li>

		<?php } if (in_array("lrgawidget_perm_sessions",$globalWidgetPermissions)){ $actLrgaTabs[] = "lrgawidget_sessions_tab";  ?>
			<li><a data-toggle="tab" href="#lrgawidget_sessions_tab"><i class="fa fa-users fa-fw"></i><span class="hidden-xs hidden-sm"> Sessions</span></a></li>

		<?php } ?>
           <li><a data-toggle="tab" href="#lrgawidget_gopro_tab"><i class="fa fa-unlock fa-fw"></i><span class="hidden-xs hidden-sm"> Go Premium ! </span></a></li> 		    
		</ul>
		<div class="tab-content">
			<div class="alert alert-danger hidden" id="lrgawidget_error"></div>
			<?php if (in_array("lrgawidget_perm_admin",$globalWidgetPermissions)){  ?>
			<div class="tab-pane " id="lrgawidget_settings_tab">
				<div class="fuelux">
					<div class="wizard" data-initialize="wizard" id="lrga-wizard" style="background-color: #FFF;">
						<div class="steps-container">
							<ul class="steps">
								<li class="active" data-name="lrga-createApp" data-step="1"><span class="badge">1</span>Create Google APP <span class="chevron"></span></li>
								<li data-step="2" data-name="lrga-getCode"><span class="badge">2</span>Authorize APP <span class="chevron"></span></li>
								<li data-step="3" data-name="lrga-profile"><span class="badge">3</span>Select Analytics Profile <span class="chevron"></span></li>
							</ul>
						</div>
						
						
						<div class="actions">
							<button type="button" class="btn btn-danger" data-lrgawidget-reset="reset" style="display: none;">
								<i class="fa fa-refresh fa-fw"></i> Reset all data and start over
							</button>
							<button type="button" class="btn btn-primary" data-reload="lrgawidget_go_express" style="display: none;">
							<i class="fa fa-arrow-circle-o-left fa-fw"></i> <i class="fa fa-magic fa-fw"></i> Go Back to Express Setup
							</button>
						</div>						

						<div class="step-content">
							<div class="step-pane active sample-pane bg-info alert" data-step="1">
								<div class="row">
									 <div id="lrgawidget_express_setup"> 
										<div class="col-md-6">
											<div class="lrgawidget_ex_left">
												<div class="box">
												  <div class="box-header with-border">
												  <i class="fa fa-magic fa-fw"></i>												  
													<h3 class="box-title">Express Setup</h3>
												  </div>
												  <div class="box-body">
													<p>Click on "<b>Get Access Code</b>" button below, and a pop-up window will open, asking you to allow "<b>Lara, The Google Analytics Widget</b>" to <b>View your Google Analytics data</b>
													. Click <b>Allow</b>, then copy and paste the access code here, and click <b>Submit</b>.
													<br><br>If you were asked to login, be sure to use the same email account that is linked to your <b>Google Analytics</b>. 
													<br><br><a class="btn btn-primary" href="javascript:gauthWindow('https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=789117741534-frb075bn85jk68ufpjg56s08hf85r007.apps.googleusercontent.com&redirect_uri=urn:ietf:wg:oauth:2.0:oob&scope=https://www.googleapis.com/auth/analytics.readonly&access_type=offline&approval_prompt=force');" >Get Access Code</a>
													
													</p>
													
													<form id="express-lrgawidget-code" name="express-lrgawidget-code" role="form">
														<input name="action" type="hidden" value="getAccessToken">
														<input name="client_id" type="hidden" value="789117741534-frb075bn85jk68ufpjg56s08hf85r007.apps.googleusercontent.com">
														<input name="client_secret" type="hidden" value="ZkJpBFuNFwv65e36C6mwnihQ">
														<div class="form-group">
															<label> Access Code</label>
															<div class="input-group">
																<div class="input-group-addon">
																	<i class="fa fa-user fa-fw"></i>
																</div>
																<input class="form-control" name="code" required="" type="text">
																<span class="input-group-btn">
																	   <button type="submit" class="btn btn-primary btn-flat" >Submit</button>
																</span>
															</div><!-- /.input group -->
														</div>
													</form>
												  </div>
												</div>
											</div>
										</div>
										
										<div  class="col-md-6">
											<div class="lrgawidget_ex_right">
												<div class="box">
												  <div class="box-header with-border">
												  <i class="fa fa-gears fa-fw"></i>												  
													<h3 class="box-title">Advanced Setup</h3>
												  </div>
												  <div class="box-body">
													<p>By clicking on "<b>Start Advanced Setup</b>" button below, The setup wizard will guide you through creating and/or configuring your own Google Application. 
													If you want a quick start, or just trying the widget, use the <b>Express Setup</b> on the left.
													<br><br><a class="btn btn-primary btn-block" href="#" data-reload="lrgawidget_go_advanced">Start Advanced Setup</a>
												  </div>
												</div>											
											</div>
										</div>
									 </div>
								 
									 <div id="lrgawidget_advanced_setup" style="display: none;">
										<div class="col-md-6">
											<form id="lrgawidget-credentials" name="lrgawidget-credentials" role="form">
												<input name="action" type="hidden" value="getAuthURL">
												<div class="form-group">
													<label>Client ID</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-user fa-fw"></i>
														</div><input class="form-control" name="client_id" required="" type="text" value="">
													</div><!-- /.input group -->
												</div>
												<div class="form-group">
													<label>Client Secret</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-lock fa-fw"></i>
														</div><input class="form-control" name="client_secret" required="" type="text" value="">
													</div><!-- /.input group -->
												</div>
												<div>
													<button class="btn btn-primary" type="submit">Submit</button>
												</div>
											</form>
										</div>
										<div class="col-md-6">
											<h2 id="enable-oauth-20-api-access">Create Google APP</h2>
											<p>To use the <b>Google Analytics</b> widget, you'll need to create a <b>Google App</b> as follows :</p>

											<ol>
												<li>Open the <a target="_blank" href="//console.developers.google.com/apis/credentials?project=_">Google Developers Console</a>.</li>
												<li>Click on <b>Select a project</b> drop-down, and choose <b>Create a new project</b>.</li>
												<li>Enter "<b>Lara</b>" as the <b>Project name</b>, then click <b>Create</b>.</li>
												<li>Select <b>Create credentials</b> and choose <b>OAuth client ID</b>.</li>
												<li>Click on <b>Configure consent screen</b> and enter "<b>Lara, The Google Analytics Widget</b>" as the <b>Product Name</b>, then click <b>Save</b>.</li>
												<li>Under <b>Application type</b>, select <b>Other</b>, enter "<b>Lara</b>" then click <b>Create</b>.</li>
												<li>Take note of the <b>client ID</b> & <b>client secret</b> then click "<b>Ok</b>".</li>
												<li>Open "<b>Google Developers Console</b>" menu, by clicking on " <i class="fa fa-bars"></i> " and select "<b>API Manager</b>".</li>
												<li>Click "<b>Analytics API</b>", then click <b>Enable API</b>. 
											</ol>
											<p>When done, paste the <b>client ID</b> & <b>client secret</b> here and click <b>Submit</b>.</p>
											
										</div>
									</div>
								</div>	
							</div>
							<div class="step-pane sample-pane bg-info alert" data-step="2">
								<div class="row">
									<div class="col-md-6">
										<form id="lrgawidget-code" name="lrgawidget-code" role="form">
											<input name="action" type="hidden" value="getAccessToken">
											<input name="client_id" type="hidden" value="">
											<input name="client_secret" type="hidden" value="">
											<div class="form-group">
												<label>Access Code</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-user fa-fw"></i>
													</div><input class="form-control" name="code" required="" type="text">
												</div><!-- /.input group -->
											</div>
											<div>
												<button class="btn btn-primary" type="submit">Submit</button>
											</div>
										</form>
									</div>
									<div class="col-md-6">
										<h2 id="enable-oauth-20-api-access">Authorize App</h2>
										<p>Click on "<b>Get Access Code</b>" button below, and a pop-up window will open, asking you to allow the <u>app you just created</u> to <b>View your Google Analytics data</b>
										. <br><br>Be sure to use the same email account that is linked to your <b>Google Analytics</b>.
										<br><br>Click <b>Allow</b>, then copy and paste the access code here, and click <b>Submit</b>.
										</p>
										
										<a class="btn btn-primary" href="#" id="code-btn">Get Access Code</a>
									</div>
								</div>
							</div>
							<div class="step-pane sample-pane bg-info alert" data-step="3">
								<div class="row">
									<div class="col-md-6">
									
									<form id="lrgawidget-setProfileID" name="lrgawidget-setProfileID" role="form">
										<input name="action" type="hidden" value="setProfileID">
										<div class="form-group">
											<label>Account</label> 
											<select class="form-control" style="width: 100%;" id="lrgawidget-accounts" name="account_id">
											</select>
										</div>
										<div class="form-group">
											<label>Property</label> 
											<select class="form-control" style="width: 100%;" id="lrgawidget-properties" name="property_id">
											</select>
										</div>									
										<div class="form-group">
											<label>View</label> 
											<select class="form-control" style="width: 100%;" id="lrgawidget-profiles" name="profile_id">
											</select>
										</div>
										
										<div class="callout" style="padding: 5px;">
											 	<input name="enable_universal_tracking" checked="checked" type="checkbox" style="margin: 0px;"> Add "<b>Google Universal Analytics</b>" tracking code to all pages.
										</div>
										<div>
											<button class="btn btn-primary" type="submit">Save</button>
										</div>
										</form>
									</div>
									<div class="col-md-6">
									    <div>
											<h2 >Profile Details</h2>
											 <label>Account Name :</label> <i id="lrgawidget-accname"></i>
											 <br><label>Property Name :</label> <i id="lrgawidget-propname"></i>  
											 <br><label>Property WebsiteUrl :</label> <i id="lrgawidget-propurl"></i> 
											 <br><label>View Name :</label> <i id="lrgawidget-vname"></i>
											 <br><label>View Type :</label> <i id="lrgawidget-vtype"></i>
		 
										</div> 
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- /.tab-pane -->
			<?php } ?>


			<?php if (in_array("lrgawidget_perm_sessions",$globalWidgetPermissions)){  ?>
			<div class="tab-pane" id="lrgawidget_sessions_tab">
				<div id="lrgawidget_sessions_chartDiv" style="height: 350px; width: 100%;"></div>
				<div class="box-footer hidden-xs hidden-sm" id="lrgawidget_sb-main">
					<div class="row">
						<div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_sessions" data-lrgawidget-plot="sessions">
							<div class="description-block border-right">
								<span class="description-text">Sessions</span>
								<h5 class="description-header"></h5>
								<div class="lrgawidget_inlinesparkline" id="lrgawidget_spline_sessions"></div>
							</div><!-- /.description-block -->
						</div><!-- /.col -->
						<div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_users" data-lrgawidget-plot="users">
							<div class="description-block border-right">
								<span class="description-text">Users</span>
								<h5 class="description-header"></h5>
								<div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_users"></div>
							</div><!-- /.description-block -->
						</div><!-- /.col -->
						<div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_pageviews" data-lrgawidget-plot="pageviews">
							<div class="description-block border-right">
								<span class="description-text">Pageviews</span>
								<h5 class="description-header"></h5>
								<div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_pageviews"></div>
							</div><!-- /.description-block -->
						</div><!-- /.col -->
						<div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_pageviewsPerSession" data-lrgawidget-plot="pageviewsPerSession">
							<div class="description-block border-right">
								<span class="description-text">Pages / Session</span>
								<h5 class="description-header"></h5>
								<div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_pageviewsPerSession"></div>
							</div><!-- /.description-block -->
						</div>
						<div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_avgSessionDuration" data-lrgawidget-plot="avgSessionDuration">
							<div class="description-block border-right">
								<span class="description-text">Avg. Session Duration</span>
								<h5 class="description-header"></h5>
								<div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_avgSessionDuration"></div>
							</div><!-- /.description-block -->
						</div>
						<div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_bounceRate" data-lrgawidget-plot="bounceRate">
							<div class="description-block border-right">
								<span class="description-text">Bounce Rate</span>
								<h5 class="description-header"></h5>
								<div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_bounceRate"></div>
							</div><!-- /.description-block -->
						</div>
						<div class="col-sm-3 col-xs-6 lrgawidget_seven-cols" id="lrgawidget_sb_percentNewSessions" data-lrgawidget-plot="percentNewSessions">
							<div class="description-block">
								<span class="description-text">% New Sessions</span>
								<h5 class="description-header"></h5>
								<div class="lrgawidget_inlinesparkline"  id="lrgawidget_spline_percentNewSessions"></div>
							</div><!-- /.description-block -->
						</div>
					</div><!-- /.row -->
				</div>
			</div>			<!-- /.tab-pane -->
			<?php } ?>
			

			<div class="tab-pane" id="lrgawidget_gopro_tab">
				<div class="row">
					<div>
						<div class="col-md-6">
							<div class="lrgawidget_gopro_buynow">
								<div class="box">
									<div class="box-header with-border">
										<i class="fa fa-unlock fa-fw"></i>
										<h3 class="box-title">Buy Premium Version</h3>
									</div>
									<div class="box-body">
										<p>Thank you for using  <b>Lara, Google Analytics Dashboard Widget</b>.
										<br><br> 
										Click <b>"Launch Demo"</b> to exprience the full features of the <b>Premium</b> version. You'll not leave your wordpress dashboard!
										<br><br>
										<p><a class="btn btn-primary btn-block lrgawidget_view_demo" href="https://wpdemo.whmcsadmintheme.com/demo.php" title="Fully working Demo .. When done, press ESC to close this window.">Launch Demo</a></p>
										
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="lrgawidget_gopro_features">
								<div class="box">
									<div class="box-header with-border">
										<i class="fa fa-list fa-fw"></i>
										<h3 class="box-title">Premium Features</h3>
									</div>
									<div class="box-body">
										<p>By buying the Premium version, You'll get access to all these amazing features :</p>
										<ul class="fa-ul">
										    <li><i class="fa-li fa fa-refresh"></i>12 months of free updates and support.
											<li><i class="fa-li fa fa-calendar"></i>Check any date range, not just the last 30 days.
											<li><i class="fa-li fa fa-unlock"></i>Access to all the following Google Analytics metrics :</li>
											<ul class="fa-ul">
												<li><i class="fa-li fa fa-search"></i>Keywords ( provided by Google Search Console).</li>
												<li><i class="fa-li fa fa-external-link-square"></i>Traffic sources.</li>
												<li><i class="fa-li fa fa-file-o"></i>Most visited pages.</li>
												<li><i class="fa-li fa fa-globe"></i>Countries.</li>
												<li><i class="fa-li fa fa-list-alt"></i>Browsers <b>and</b> their versions.</li>
												<li><i class="fa-li fa fa-font"></i>Languages.</li>
												<li><i class="fa-li fa fa-desktop"></i>Operating Systems <b>and</b> their versions.</li>
												<li><i class="fa-li fa fa-arrows-alt"></i>Screen Resolutions.</li>
											</ul>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	


		</div><!-- /.tab-content -->
	</div>  
  </div>
</div>


</div>
</div>

</div>
<!-- /.revise -->
<?php if (!empty($actLrgaTabs[0])){ ?>
	<script type="text/javascript">
	var actLrgaTabs = '<?php echo $actLrgaTabs[0]; ?>';
	jQuery(document).ready(function($){
		$(".wrap:eq(1)").children("h1:first").remove();
		$("#adv-settings fieldset").append('<label for="lrgawidget_panel_hide"><input id="lrgawidget_panel_hide" type="checkbox" checked="checked">Lara, Google Analytics Dashboard Widget</label>');
		$("#lrgawidget_remove").on('click', function (e) {
			e.preventDefault(); 
			$("#lrgawidget_panel_hide").click();
		});		
		$(".daterangepicker").removeClass("daterangepicker dropdown-menu opensleft").addClass("lrga_bs daterangepicker dropdown-menu opensleft");
	    $('[data-toggle="lrgawidget_tooltip"]').tooltip(); 
		$("#lrgawidget a[href='#"+actLrgaTabs+"']").tab('show');	
        $(".lrgawidget_view_demo").colorbox({iframe:true, innerWidth:"80%", innerHeight:575, scrolling: false});
		
	});
	</script>
<?php } ?>