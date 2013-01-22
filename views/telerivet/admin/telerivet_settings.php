<table style="width: 630px;" class="my_table">
	<tr>
		<td style="width:60px;">
			<span class="big_blue_span"><?php echo Kohana::lang('ui_main.step');?> 1:</span>
		</td>
		<td>
			<h4 class="fix">Sign up for Telerivet's service at <a target='_blank' href='https://telerivet.com'>https://telerivet.com</a>.</h4>
		</td>
	</tr>
	<tr>
		<td style="width:60px;">
			<span class="big_blue_span"><?php echo Kohana::lang('ui_main.step');?> 2:</span>
		</td>
		<td>
            <h4 class="fix">Follow the instructions on telerivet.com to add a phone number. </h4>
            For most countries outside the US/UK/Canada, the recommended way is to install the Telerivet app on an Android phone to turn the phone into a SMS gateway server.
		</td>
	</tr>    
	<tr>
		<td>
			<span class="big_blue_span"><?php echo Kohana::lang('ui_main.step');?> 3:</span>
		</td>
		<td>
			<h4 class="fix">Go to the API tab in your Telerivet account, and enter the following information:</h4>
			<div class="row">
				<h4>API Key:</h4>
				<?php print form::input('api_key', $form['api_key'], ' class="text title_2" style="width:300px"'); ?>
			</div>
			<div class="row">
				<h4>Project ID:</h4>
				<?php print form::input('project_id', $form['project_id'], ' class="text title_2" style="width:300px"'); ?>
			</div>
            <br />
            Note: in order to send messages, you will also need to select 'telerivet' and enter your Telerivet phone number on 
            the <a target='_blank' href='<?php echo url::site()."admin/settings/sms"; ?>'>SMS Setup Options</a> page.
        </td>
	</tr>
	<tr>
		<td>
			<span class="big_blue_span"><?php echo Kohana::lang('ui_main.step');?> 4:</span>
		</td>
		<td>
			<h4 class="fix">Go to the Service tab in your Telerivet account, and add a new service. Select "Application on your own server".</h4>
            For the Webhook URL, enter the following: <pre><?php echo $webhook_url; ?></pre>
            After creating your service, click <strong>Show</strong> next to <code>secret=****************************</code> on your Service page, and copy the Webhook Secret below:
			<div class="row">
				<h4>Webhook Secret:</h4>
				<?php print form::input('webhook_secret', $form['webhook_secret'], ' class="text title_2" style="width:300px"'); ?>
			</div>
		</td>
	</tr>        
</table>