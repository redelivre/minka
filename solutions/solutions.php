<?php

class Solutions
{
	function __construct()
	{
		add_action('init', array($this, 'Add_custom_Post'));
	}

	function Add_custom_Post()
	{
		$labels = array
		(
				'name' => __('Solutions','minka'),
				'singular_name' => __('Solution','minka'),
				'add_new' => __('Add new','minka'),
				'add_new_item' => __('Add new solution','minka'),
				'edit_item' => __('Edit solution','minka'),
				'new_item' => __('New Solution','minka'),
				'view_item' => __('View Solution','minka'),
				'search_items' => __('Search Solution','minka'),
				'not_found' =>  __('Solution not found','minka'),
				'not_found_in_trash' => __('Solution not found in the trash','minka'),
				'parent_item_colon' => '',
				'menu_name' => __('Solutions','minka')
	
		);
	
		$args = array
		(
				'label' => __('Solutions','minka'),
				'labels' => $labels,
				'description' => __('Solutions','minka'),
				'public' => true,
				'publicly_queryable' => true, // public
				//'exclude_from_search' => '', // public
				'show_ui' => true, // public
				'show_in_menu' => true,
				'menu_position' => 5,
				// 'menu_icon' => '',
				'capability_type' => array('solution','solutions'),
				'map_meta_cap' => true,
				'hierarchical' => false,
				'supports' => array('title', 'editor', 'author', 'excerpt', 'trackbacks', 'revisions', 'comments'),
				'register_meta_box_cb' => array($this, 'minka_solution_custom_meta'), // função para chamar na edição
				//'taxonomies' => array('post_tag'), // Taxionomias já existentes relaciondas, vamos criar e registrar na sequência
				'permalink_epmask' => 'EP_PERMALINK ',
				'has_archive' => true, // Opção de arquivamento por slug
				'rewrite' => true,
				'query_var' => true,
				'can_export' => true//, // veja abaixo
				//'show_in_nav_menus' => '', // public
				//'_builtin' => '', // Core
				//'_edit_link' => '' // Core
	
		);
	
		register_post_type("solution", $args);
	}
	
	function minka_solution_custom_meta()
	{
		add_meta_box("solution_meta", "Solution Details", array($this, 'solution_meta'), 'solution', 'side', 'default');
	}
	
	function solution_meta()
	{
		/*
		global $post;
		$custom = get_post_custom($post->ID);
		$options_plugin_delibera = delibera_get_config();
	
		if(!is_array($custom)) $custom = array();
		$validacoes = array_key_exists("numero_validacoes", $custom) ?  $custom["numero_validacoes"][0] : 0;
	
		$min_validacoes = array_key_exists("min_validacoes", $custom) ?  $custom["min_validacoes"][0] : htmlentities($options_plugin_delibera['minimo_validacao']);
	
		$situacao = delibera_get_situacao($post->ID);
	
		$dias_validacao = intval(htmlentities($options_plugin_delibera['dias_validacao']));
		$dias_discussao = intval(htmlentities($options_plugin_delibera['dias_discussao']));
		$dias_relatoria = intval(htmlentities($options_plugin_delibera['dias_relatoria']));
		$dias_votacao_relator = intval(htmlentities($options_plugin_delibera['dias_votacao_relator']));
	
		if($options_plugin_delibera['validacao'] == "S") // Adiciona prazo de validação se for necessário
		{
			$dias_discussao += $dias_validacao;
		}
	
		$dias_votacao = $dias_discussao + intval(htmlentities($options_plugin_delibera['dias_votacao']));
	
		if($options_plugin_delibera['relatoria'] == "S") // Adiciona prazo de relatoria se for necessário
		{
			$dias_votacao += $dias_relatoria;
			$dias_relatoria += $dias_discussao;
			if($options_plugin_delibera['eleicao_relator'] == "S") // Adiciona prazo de vatacao relator se for necessário
			{
				$dias_votacao += $dias_votacao_relator;
				$dias_relatoria += $dias_votacao_relator;
				$dias_votacao_relator += $dias_discussao;
			}
		}
	
		$now = strtotime(date('Y/m/d')." 11:59:59");
	
		$prazo_validacao_sugerido = strtotime("+$dias_validacao days", $now);
		$prazo_discussao_sugerido = strtotime("+$dias_discussao days", $now);
		$prazo_eleicao_relator_sugerido = strtotime("+$dias_votacao_relator days", $now);
		$prazo_relatoria_sugerido = strtotime("+$dias_relatoria days", $now);
		$prazo_votacao_sugerido = strtotime("+$dias_votacao days", $now);
	
		$prazo_validacao = date('d/m/Y', $prazo_validacao_sugerido);
		$prazo_discussao = date('d/m/Y', $prazo_discussao_sugerido);
		$prazo_eleicao_relator = date('d/m/Y', $prazo_eleicao_relator_sugerido);
		$prazo_relatoria = date('d/m/Y', $prazo_relatoria_sugerido);
		$prazo_votacao = date('d/m/Y', $prazo_votacao_sugerido);
	
		if (
				$options_plugin_delibera['representante_define_prazos'] == "N" &&
				!($post->post_status == 'draft' ||
						$post->post_status == 'auto-draft' ||
						$post->post_status == 'pending')
		)
		{
			$disable_edicao = 'readonly="readonly"';
		} else {
			$disable_edicao = '';
		}
	
		if(!($post->post_status == 'draft' ||
				$post->post_status == 'auto-draft' ||
				$post->post_status == 'pending'))
		{
			$prazo_validacao = array_key_exists("prazo_validacao", $custom) ?  $custom["prazo_validacao"][0] : $prazo_validacao;
			$prazo_discussao = array_key_exists("prazo_discussao", $custom) ?  $custom["prazo_discussao"][0] : $prazo_discussao;
			$prazo_eleicao_relator = array_key_exists("prazo_eleicao_relator", $custom) ?  $custom["prazo_eleicao_relator"][0] : $prazo_eleicao_relator;
			$prazo_relatoria = array_key_exists("prazo_relatoria", $custom) ?  $custom["prazo_relatoria"][0] : $prazo_relatoria;
			$prazo_votacao = array_key_exists("prazo_votacao", $custom) ?  $custom["prazo_votacao"][0] : $prazo_votacao;
		}
	
		if($options_plugin_delibera['validacao'] == "S")
		{
			?>
			<p>	
				<label for="min_validacoes" class="label_min_validacoes"><?php _e('Mínimo de Validações','delibera'); ?>:</label>
				<input <?php echo $disable_edicao ?> id="min_validacoes" name="min_validacoes" class="min_validacoes widefat" value="<?php echo $min_validacoes; ?>"/>
			</p>
			<p>
				<label for="prazo_validacao" class="label_prazo_validacao"><?php _e('Prazo para Validação','delibera') ?>:</label>
				<input <?php echo $disable_edicao ?> id="prazo_validacao" name="prazo_validacao" class="prazo_validacao widefat hasdatepicker" value="<?php echo $prazo_validacao; ?>"/>
			</p>
		<?php
		} 
		?>
		<p>
			<label for="prazo_discussao" class="label_prazo_discussao"><?php _e('Prazo para Discussões','delibera') ?>:</label>
			<input <?php echo $disable_edicao ?> id="prazo_discussao" name="prazo_discussao" class="prazo_discussao widefat hasdatepicker" value="<?php echo $prazo_discussao; ?>"/>
		</p>
		<?php 
		if($options_plugin_delibera['relatoria'] == "S")
		{
			if($options_plugin_delibera['eleicao_relator'] == "S")
			{
			?>
				<p>
					<label for="prazo_eleicao_relator" class="label_prazo_eleicao_relator"><?php _e('Prazo para Eleição de Relator','delibera') ?>:</label>
					<input <?php echo $disable_edicao ?> id="prazo_eleicao_relator" name="prazo_eleicao_relator" class="prazo_eleicao_relator widefat hasdatepicker" value="<?php echo $prazo_eleicao_relator; ?>"/>
				</p>
			<?php
			}
		?>
			<p>
				<label for="prazo_relatoria" class="label_prazo_relatoria"><?php _e('Prazo para Relatoria','delibera') ?>:</label>
				<input <?php echo $disable_edicao ?> id="prazo_relatoria" name="prazo_relatoria" class="prazo_relatoria widefat hasdatepicker" value="<?php echo $prazo_relatoria; ?>"/>
			</p>
		<?php
		}
		?>
		<p>
			<label for="prazo_votacao" class="label_prazo_votacao"><?php _e('Prazo para Votações','delibera') ?>:</label>
			<input <?php echo $disable_edicao ?> id="prazo_votacao" name="prazo_votacao" class="prazo_votacao widefat hasdatepicker" value="<?php echo $prazo_votacao; ?>"/>
		</p>
		<?php */
	}
	
}

new Solutions();

?>