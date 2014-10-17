<?php do_action( 'before_signup_form' ); ?>

	<?php if(!is_user_logged_in()) : ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#captcha_code").removeAttr("style");
		});
	</script>
	
	<div class="container-registro">
		
		<div class="titulo">
			<h1><?php echo _x('Cadastre-se', 'registro-de-usuario', 'redelivre'); ?></h1>
		</div>
		
		<form class="formulario-de-registro-padrao" id="registerform">
			<div class="campos">
				<p>
					<label for="custom-register-username"><?php echo _x('Nome de usuário', 'registro-de-usuario', 'minka'); ?></label> <br />
					<input type="text" id="custom-register-username" class="input" minlength="2" id="user_login" />
				</p>
				
				<p>
					<label for="custom-register-realname"><?php echo _x('Nome completo', 'registro-de-usuario', 'minka'); ?></label><br />
					<input type="text" id="custom-register-realname" class="input" />
				</p>
				
				<p>
					<label for="custom-register-password"><?php echo _x('Senha', 'registro-de-usuario', 'minka'); ?></label> <br />
					<input type="password" id="custom-register-password" class="input" />
				</p>
				
				<p>
					<label for="custom-register-password-review"><?php echo _x('Repita sua senha', 'registro-de-usuario', 'minka'); ?></label> <br />
					<input type="password" id="custom-register-password-review" class="input" />
				</p>
				<p>
					<label for="custom-register-email"><?php echo _x('Email', 'registro-de-usuario', 'minka'); ?></label> <br />
					<input type="email" required="required" id="custom-register-email" name="custom-register-email" class="input" />
				</p>
				<p>
					<label for="custom-register-city"><?php _e('City', 'minka'); ?></label><br />
					<input type="text" id="custom-register-city" name="custom-register-city" class="input" />
				</p>
				<p>
					<label for="custom-register-country"><?php _e('Country', 'minka'); ?></label><br />
					<input type="text" id="custom-register-country" name="custom-register-country" class="input" />
				</p>
				
				<?php
					if(class_exists('siCaptcha', false))
					{
						global $registro_captcha;
						$registro_captcha->si_captcha_register_form();
					}
				?>
				<input type="button" value="enviar" id="custom-register-send" />
			
			</div>
			
			
			
		</form>
		
		<div id="custom-register-resposta">
					
		</div>
		<?php else : ?>
			<?php echo _x('Você está logado neste momento, para efetuar um novo registro será preciso fazer', 'registro-de-usuario', 'minka');?> <a href="' . wp_logout_url() . '"><?php _x('logout', 'registro-de-usuario', 'minka'); ?></a>'
		<?php endif; ?>
	</div>
<?php do_action( 'after_signup_form' ); ?>