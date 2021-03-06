<?php
$form = new Appform();
if(isset($errors)) {
   $form->errors = $errors;
}
if(isset($username)) {
   $form->values['username'] = $username;
}
// set custom classes to get labels moved to bottom:
$form->error_class = 'error block';
$form->info_class = 'info block';

?>
<div id="box">
   <div class="block">
      <h1><?php echo __('login'); ?></h1>
      <div class="content">
<?php
echo $form->open('user/login');
echo '<table><tr><td style="vertical-align: top;">';
echo '<ul>';

echo '<li>'.$form->label('username', __('email.or.username')).'</li>';
echo $form->input('username', null, array('class' => 'text twothirds'));

echo '<li>'.$form->label('password', __('password'),array('style'=>'display: inline; margin-right:10px;')).
     '<small> '.Html::anchor('user/forgot', __('?forgot.password')).'<br></small>'.
     '</li>';
echo $form->password('password', null, array('class' => 'text twothirds'));


$authClass = new ReflectionClass(get_class(Auth::instance()));

//set a valid salt in useradmin config or your bootstrap.php
if( $authClass->hasMethod('auto_login') AND Cookie::$salt )
{
    echo '<li>'.Kohana_Form::checkbox('remember','remember',false,array('style'=>'margin-right: 10px','id'=>'remember')).
            $form->label('remember', __('remember.me'),array('style'=>'display: inline')).
            $form->submit(NULL, __('login'),array('style'=>'float: right;')).
        '</li>';
    echo '</ul>';
}else{
    echo '</ul>';
    echo $form->submit(NULL, __('login'));
}
echo $form->close();
echo '</td><td width="5" style="border-right: 1px solid #DDD;">&nbsp;</td><td><td style="padding-left: 2px; vertical-align: top;">';

$registerEnabled = Kohana::$config->load('useradmin.register_enabled');

if($registerEnabled || !empty($providers)) {
    echo '<ul>';
    if($registerEnabled)
        echo '<li style="height: 61px">'.__('?dont.have.account').'<br />'.Html::anchor('user/register', __('register.new.account')).'.</li>';
    if(!empty($providers)) 
    {
        if($registerEnabled)
            echo '<li style="padding-bottom: 8px;"><label>'.__('register.or.providerchange').':</label></li>';
        else
            echo '<li style="padding-bottom: 8px;"><label>'.__('login.using.provider').':</label></li>';

        echo '<li>';
        foreach($providers as $provider=>$enabled)
        {
            if($enabled){
                echo '<a class="login_provider" style="background: #FFF url(\''.URL::site(sprintf('/useradmin_assets/img/%s.png',$provider)).'\') no-repeat center center" '.
                        'href="'.URL::site('/user/provider/'.$provider).'"></a>';
            }
        }
        echo '<br style="clear: both;">
        </li>';
    }
    echo '</ul>';
}
echo '</td></tr></table>';
?>
      </div>
   </div>
</div>


