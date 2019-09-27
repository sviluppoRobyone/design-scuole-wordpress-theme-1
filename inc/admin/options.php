<?php
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function dsi_register_main_options_metabox() {
	$prefix = '';


	$args = array(
		'id'           => 'dsi_options_header',
		'title'        => esc_html__( 'Configurazione', 'design_scuole_italia' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'dsi_options',
		'tab_group'    => 'dsi_options',
		'tab_title'    => __('Opzioni di base', "design_scuole_italia"),
		'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		'icon_url'        => 'dashicons-admin-multisite', // Menu icon. Only applicable if 'parent_slug' is left empty.
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'dsi_options_display_with_tabs';
	}

	$header_options = new_cmb2_box( $args );

    $header_options->add_field( array(
        'id' => $prefix . 'home_istruzioni',
        'name'        => __( 'Configurazione Scuola', 'design_scuole_italia' ),
        'desc' => __( 'Area di configurazione delle informazioni di base' , 'design_scuole_italia' ),
        'type' => 'title',
    ) );


	$header_options->add_field( array(
		'id' => $prefix . 'tipologia_scuola',
		'name'        => __( 'Tipologia *', 'design_scuole_italia' ),
		'desc' => __( 'La Tipologia della scuola. Es: "Liceo Scientifico Statale"' , 'design_scuole_italia' ),
		'type' => 'text',
		'attributes'    => array(
			'required'    => 'required'
		),
	) );

	$header_options->add_field( array(
		'id' => $prefix . 'nome_scuola',
		'name'        => __( 'Nome Scuola *', 'design_scuole_italia' ),
		'desc' => __( 'Il Nome della Scuola' , 'design_scuole_italia' ),
		'type' => 'text',
		'attributes'    => array(
			'required'    => 'required'
		),
	) );

	$header_options->add_field( array(
		'id' => $prefix . 'luogo_scuola',
		'name'        => __( 'Città *', 'design_scuole_italia' ),
		'desc' => __( 'La città dove risiede la Scuola' , 'design_scuole_italia' ),
		'type' => 'text',
		'attributes'    => array(
			'required'    => 'required'
		),
	) );


    /**
     * Registers options page "Home".
     */

    $args = array(
        'id'           => 'dsi_options_home',
        'title'        => esc_html__( 'Home Page', 'design_scuole_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'homepage',
        'parent_slug'  => 'dsi_options',
        'tab_group'    => 'dsi_options',
        'tab_title'    => __('Home Page', "design_scuole_italia"),	);

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dsi_options_display_with_tabs';
    }

    $home_options = new_cmb2_box( $args );

    $home_options->add_field( array(
        'id' => $prefix . 'home_istruzioni_1',
        'name'        => __( 'Sezione Notizie', 'design_scuole_italia' ),
        'desc' => __( 'Gestione Notizie / Articoli / Eventi mostrati in home page' , 'design_scuole_italia' ),
        'type' => 'title',
    ) );

    $home_options->add_field(array(
        'id' => $prefix . 'home_is_selezione_automatica',
        'name' => __('Selezione Automatica', 'design_scuole_italia'),
        'desc' => __('Seleziona per mostrare automaticamente gli articoli in base alla configurazione della Pagina "Notizie"', 'design_scuole_italia'),
        'type' => 'radio_inline',
        'default' => 'true',
        'options' => array(
            'true' => __('Si', 'design_scuole_italia'),
            'false' => __('No', 'design_scuole_italia'),
        ),
    ));



    $home_options->add_field(array(
            'name' => __('Selezione articoli ', 'design_scuole_italia'),
            'desc' => __('Seleziona gli articoli da mostrare in Home Page. NB: Selezionane 3 o multipli di 3 per evitare buchi nell\'impaginazione.  ', 'design_scuole_italia'),
            'id' => $prefix . 'home_articoli_manuali_',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => false, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => -1,
                    'post_type'      => array('post', 'page', 'evento'),
                ), // override the get_posts args
            ),
            'attributes' => array(
                'data-conditional-id' => $prefix . 'home_is_selezione_automatica',
                'data-conditional-value' => "false",
            ),
        )
    );


    /**
	 * Registers options page "La Scuola".
	 */
	$args = array(
		'id'           => 'dsi_options_la_scuola',
		'title'        => esc_html__( 'La Scuola', 'design_scuole_italia' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'la_scuola',
		'tab_title'    => __('Pagina "Scuola"', "design_scuole_italia"),
		'parent_slug'  => 'dsi_options',
		'tab_group'    => 'dsi_options',

	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'dsi_options_display_with_tabs';
	}

	$main_options = new_cmb2_box( $args );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */


    $scuola_landing_url = dsi_get_template_page_url("page-templates/la-scuola.php");

    $main_options->add_field( array(
        'id' => $prefix . 'scuola_istruzioni',
        'name'        => __( 'Sezione La Scuola', 'design_scuole_italia' ),
        'desc' => __( 'Inserisci qui le informazioni utili a popolare <a href="'.$scuola_landing_url.'">la pagina di panoramica della Scuola</a>.' , 'design_scuole_italia' ),
        'type' => 'title',
        ) );


    $main_options->add_field( array(
		'id' => $prefix . 'immagine',
		'name'        => __( 'Immagine', 'design_scuole_italia' ),
		'desc' => __( 'Immagine di presentazione della scuola' , 'design_scuole_italia' ),
		'type'    => 'file',
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Aggiungi Immagine' // Change upload button text. Default: "Add or Upload File"
		),
		// query_args are passed to wp.media's library query.
		'query_args' => array(
			 'type' => array(
			 	'image/gif',
			 	'image/jpeg',
			 	'image/png',
			 ),
		),
		'preview_size' => 'large', // Image size to use when previewing in the admin.
		'attributes'    => array(
			'required'    => 'required'
		),
	) );

	$main_options->add_field( array(
		'id' => $prefix . 'citazione',
			'name'        => __( 'Citazione', 'design_scuole_italia' ),
		'desc' => __( 'Breve (compresa tra 70 e 140 caratteri spazi inclusi) frase identificativa della missione o della identità dell\'istituto . Es. "Da sempre un punto di riferimento per la formazione degli studenti a Roma" Es. "La scuola è una comunità: costruiamo insieme il futuro". Link alla pagina di presentazione della missione della scuola' , 'design_scuole_italia' ),
		'type' => 'textarea',
		'attributes'    => array(
            'maxlength'  => '140',
			'minlength'  => '70'
		),
	) );



	$main_options->add_field( array(
		'name'        => __( 'La Storia', 'design_scuole_italia' ),
		'desc' => __('Timeline della Scuola', 'design_scuole_italia' ),
		'type' => 'title',
		'id' => $prefix . 'prefisso_storia',
	) );



	$main_options->add_field( array(
		'id' => $prefix . 'descrizione_scuola',
		'title'        => __( 'La Storia', 'design_scuole_italia' ),
		'name'        => __( 'Descrizione', 'design_scuole_italia' ),
		'desc' => __( 'Descrizione introduttiva della timeline' , 'design_scuole_italia' ),
		'type' => 'textarea_small',
	) );

	$timeline_group_id = $main_options->add_field( array(
		'id'           => $prefix . 'timeline',
		'type'        => 'group',
		'name'        => 'Timeline',
		'desc' => __( 'Ogni fase è costruita attraverso data, titolo (max 60 caratteri) e descrizione breve (max 140 caratteri). NB: Se è un istituto comprende le tappe delle scuole che ne fanno parte' , 'design_scuole_italia' ),
		'repeatable'  => true,
		'options'     => array(
			'group_title'   => __( 'Fase {#}', 'design_scuole_italia' ),
			'add_button'    => __( 'Aggiungi un elemento', 'design_scuole_italia' ),
			'remove_button' => __( 'Rimuovi l\'elemento ', 'design_scuole_italia' ),
			'sortable'      => true,  // Allow changing the order of repeated groups.
		),
	) );


	$main_options->add_group_field( $timeline_group_id, array(
		'id' => $prefix . 'data_timeline',
		'name'        => __( 'Data', 'design_scuole_italia' ),
		'type' => 'text_date',
		'date_format' => 'd-m-Y',
		'data-datepicker' => json_encode( array(
			'yearRange' => '-100:+0',
		) ),
	) );

	$main_options->add_group_field( $timeline_group_id, array(
		'id' => $prefix . 'titolo_timeline',
		'name'        => __( 'Titolo', 'design_scuole_italia' ),
		'type' => 'text',
	) );
	$main_options->add_group_field( $timeline_group_id, array(
		'id' => $prefix . 'descrizione_timeline',
		'name'        => __( 'Descrizione', 'design_scuole_italia' ),
		'type' => 'textarea_small',
	) );

	$main_options->add_field( array(
		'name'        => __( 'Le Strutture', 'design_scuole_italia' ),
		'desc' => __('Organizzazione scolastica', 'design_scuole_italia' ),
		'type' => 'title',
		'id' => $prefix . 'prefisso_strutture_scuola',
	) );

	$main_options->add_field( array(
		'id' => $prefix . 'descrizione_strutture',
		'title'        => __( 'Le Strutture', 'design_scuole_italia' ),
		'name'        => __( 'Descrizione', 'design_scuole_italia' ),
		'desc' => __( 'Es: Una scuola è fatta di persone. Ecco come siamo organizzati e come possiamo entrare in contatto' , 'design_scuole_italia' ),
		'type' => 'textarea_small',
	) );


	$main_options->add_field( array(
		'id' => $prefix . 'link_strutture_evidenza',
		'name'    => __( 'Le Strutture', 'design_scuole_italia' ),
		'desc' => __( 'Seleziona qui le principali strutture organizzative (es: La Dirigenza, La segreteria, etc)  <a href="post-new.php?post_type=struttura">Qui puoi creare una struttura.</a> ' , 'design_scuole_italia' ),
		'type'    => 'custom_attached_posts',
		'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options' => array(
			'show_thumbnails' => false, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args'      => array(
				'posts_per_page' => -1,
				'post_type'      => 'struttura',
			), // override the get_posts args
		),
	) );


	$main_options->add_field( array(
		'name'        => __( 'Commissioni', 'design_scuole_italia' ),
		'desc' => __('Commissioni e Gruppi di Lavoro', 'design_scuole_italia' ),
		'type' => 'title',
		'id' => $prefix . 'prefisso_commissioni_scuola',
	) );


	$main_options->add_field( array(
		'id' => $prefix . 'link_strutture_commissioni',
		'name'    => __( 'Commissioni e Gruppi di Lavoro', 'design_scuole_italia' ),
		'desc' => __( 'Seleziona qui le principali strutture organizzative di tipo Commissione o Gruppo di lavoro.  <a href="post-new.php?post_type=struttura">Qui puoi creare una struttura.</a> ' , 'design_scuole_italia' ),
		'type'    => 'custom_attached_posts',
		'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options' => array(
			'show_thumbnails' => false, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args'      => array(
				'posts_per_page' => -1,
				'post_type'      => 'struttura',
			), // override the get_posts args
		),
	) );


	$main_options->add_field( array(
		'name'        => __( 'I Luoghi', 'design_scuole_italia' ),
		'desc' => __('Immagini dei luoghi della Scuola', 'design_scuole_italia' ),
		'type' => 'title',
		'id' => $prefix . 'prefisso_luoghi_storia',
	) );

	$main_options->add_field( array(
		'id' => $prefix . 'descrizione_gallery_luoghi',
		'title'        => __( 'I Luoghi', 'design_scuole_italia' ),
		'name'        => __( 'Descrizione', 'design_scuole_italia' ),
		'desc' => __( 'Es: Testo descrittivo dei luoghi della scuola' , 'design_scuole_italia' ),
		'type' => 'textarea_small',
	) );

	$main_options->add_field( array(
		'desc' => 'Una selezione di circa 5 immagini significative della scuola/istituto',
		'id'           => $prefix . 'immagini_luoghi',
		'name'        => __( 'Gallery', 'design_scuole_italia' ),
		'type' => 'file_list',
		// 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		'query_args' => array( 'type' => 'image' ), // Only images attachment
		// Optional, override default text strings
		'text' => array(
			'add_upload_files_text' => 'Aggiungi', // default: "Add or Upload Files"
			'remove_image_text' => 'Rimuovi', // default: "Remove Image"
			'file_text' => 'File:', // default: "File:"
			'file_download_text' => 'Download', // default: "Download"
			'remove_text' => 'Elimina', // default: "Remove"
		),
	) );

	$main_options->add_field( array(
		'name'        => __( 'Le carte della scuola', 'design_scuole_italia' ),
		'desc' => __('Utilizza le carte per presentare il Piano triennale dell\'offerta formativa (PTOF), il Piano di inclusione e il Regolamento di Istituto o altri documenti.', 'design_scuole_italia' ),
		'type' => 'title',
		'id' => $prefix . 'prefisso_carte',
	) );

	$main_options->add_field( array(
		'id' => $prefix . 'descrizione_carte',
		'title'        => __( 'Le Carte', 'design_scuole_italia' ),
		'name'        => __( 'Descrizione', 'design_scuole_italia' ),
		'desc' => __( 'E\' l\'accesso a tutti i documenti della scuola. Es: La scuola raccontata attraverso i documenti più importanti, come il piano triennale dell\'offerta formativa' , 'design_scuole_italia' ),
		'type' => 'textarea_small',
	) );



	$main_options->add_field( array(
		'id' => $prefix . 'link_schede_documenti',
		'name'    => __( 'Le Carte', 'design_scuole_italia' ),
		'desc' => __( 'Inserisci qui tutti i documenti che ritieni utili per presentare la scuola.  <a href="post-new.php?post_type=documento">Qui puoi creare un documento.</a> ' , 'design_scuole_italia' ),
		'type'    => 'custom_attached_posts',
		'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options' => array(
			'show_thumbnails' => false, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args'      => array(
				'posts_per_page' => -1,
				'post_type'      => 'documento',
			), // override the get_posts args
		),
	) );


	$main_options->add_field( array(
		'name'        => __( 'I numeri della Scuola', 'design_scuole_italia' ),
		'desc' => __('Inserisci il numero di studenti e classi della Scuola', 'design_scuole_italia' ),
		'type' => 'title',
		'id' => $prefix . 'prefisso_numeri',
	) );

	$main_options->add_field( array(
		'id' => $prefix . 'numeri_descrizione',
		'name'        => __( 'Descrizione', 'design_scuole_italia' ),
		'desc' => __( 'Breve descrizione (140 caratteri) *' , 'design_scuole_italia' ),
		'type' => 'textarea_small',
		'attributes'    => array(
			'required'    => 'required'
		),
	) );


	$main_options->add_field( array(
		'id' => $prefix . 'studenti',
		'name'        => __( 'Studenti *', 'design_scuole_italia' ),
		'desc' => __( 'Numero di studenti iscritti a scuola' , 'design_scuole_italia' ),
		'type' => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
			'required'    => 'required'
		),
		'sanitization_cb' => 'absint',
		'escape_cb'       => 'absint',
	) );

	$main_options->add_field( array(
		'id' => $prefix . 'classi',
		'name'        => __( 'Classi *', 'design_scuole_italia' ),
		'desc' => __( 'Numero di classi della scuola' , 'design_scuole_italia' ),
		'type' => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
			'required'    => 'required'
		),
		'sanitization_cb' => 'absint',
		'escape_cb'       => 'absint',
	) );

	$main_options->add_field( array(
		'id' => $prefix . 'url_scuoleinchiaro',
		'name'        => __( 'Per approfondire *', 'design_scuole_italia' ),
		'desc' => __( 'Link alla scheda della scuola all\'interno di "scuola in chiaro"' , 'design_scuole_italia' ),
		'type' => 'text_url',
		'attributes'    => array(
			'required'    => 'required'
		),
	) );





	/**
	 * Registers Servizi option page.
	 */

	$args = array(
		'id'           => 'dsi_options_servizi',
		'title'        => esc_html__( 'I Servizi', 'design_scuole_italia' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'servizi',
		'parent_slug'  => 'dsi_options',
		'tab_group'    => 'dsi_options',
		'tab_title'    => __('Pagina "Servizi"', "design_scuole_italia"),	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'dsi_options_display_with_tabs';
	}

	$servizi_options = new_cmb2_box( $args );


    $servizi_landing_url = dsi_get_template_page_url("page-templates/servizi.php");
    $servizi_options->add_field( array(
        'id' => $prefix . 'servizi_istruzioni',
        'name'        => __( 'Sezione I Servizi', 'design_scuole_italia' ),
        'desc' => __( 'Inserisci qui le informazioni utili a popolare <a href="'.$servizi_landing_url.'">la pagina di panoramica dei Servizi</a>.' , 'design_scuole_italia' ),
        'type' => 'title',
    ) );


    $servizi_options->add_field( array(
		'id' => $prefix . 'testo_servizi',
		'name'        => __( 'Descrizione Sezione', 'design_scuole_italia' ),
		'desc' => __( 'es: "I servizi offerti dal liceo scientifico Enriques dedicati a tutti i genitori, studenti, personale ATA e docenti"' , 'design_scuole_italia' ),
		'type' => 'textarea',
		'attributes'    => array(
			'maxlength'  => '140'
		),
	) );


	$servizi_options->add_field( array(
			'name'       => __('Tipologie Servizi', 'design_scuole_italia' ),
			'desc' => __( 'Servizi aggregati per tipologie. Seleziona le tipologie da mostrare. ', 'design_scuole_italia' ),
			'id' => $prefix . 'tipologie_servizi',
			'type'    => 'pw_multiselect',
			'options' => dsi_get_tipologia_servizi_options(),
			'attributes' => array(
				'placeholder' =>  __( 'Seleziona e ordina le tipologie di servizi da mostrare nella HomePage di sezione', 'design_scuole_italia' ),
			),
		)
	);


	/**
	 * Registers Notizie option page.
	 */

	$args = array(
		'id'           => 'dsi_options_notizie',
		'title'        => esc_html__( 'Le Notizie', 'design_scuole_italia' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'notizie',
		'parent_slug'  => 'dsi_options',
		'tab_group'    => 'dsi_options',
		'tab_title'    => __('Pagina "Notizie"', "design_scuole_italia"),	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'dsi_options_display_with_tabs';
	}

	$notizie_options = new_cmb2_box( $args );

    $notizie_landing_url = dsi_get_template_page_url("page-templates/notizie.php");
    $notizie_options->add_field( array(
        'id' => $prefix . 'notizie_istruzioni',
        'name'        => __( 'Sezione Le Notizie', 'design_scuole_italia' ),
        'desc' => __( 'Inserisci qui le informazioni utili a popolare <a href="'.$notizie_landing_url.'">la pagina di panoramica delle Notizie</a>.' , 'design_scuole_italia' ),
        'type' => 'title',
    ) );


    $notizie_options->add_field( array(
		'id' => $prefix . 'testo_notizie',
		'name'        => __( 'Descrizione Sezione', 'design_scuole_italia' ),
		'desc' => __( 'es: "Le notizie del liceo scientifico Enriques dedicate a tutti i genitori, studenti, personale ATA e docenti"' , 'design_scuole_italia' ),
		'type' => 'textarea',
		'attributes'    => array(
			'maxlength'  => '140'
		),
	) );

	$notizie_options->add_field( array(
			'name'       => __('Tipologie Notizie', 'design_scuole_italia' ),
			'desc' => __( 'Articoli aggregati per tipologie (es: articoli, circolari, notizie), . Seleziona le tipologie da mostrare. ', 'design_scuole_italia' ),
			'id' => $prefix . 'tipologie_notizie',
			'type'    => 'pw_multiselect',
			'options' => dsi_get_tipologia_articoli_options(),
			'attributes' => array(
				'placeholder' =>  __( 'Seleziona e ordina le tipologie di articoli da mostrare nella HomePage di sezione', 'design_scuole_italia' ),
			),
		)
	);


	/**
	 * Registers Didattica option page.
	 */

	$args = array(
		'id'           => 'dsi_options_didattica',
		'title'        => esc_html__( 'La Didattica', 'design_scuole_italia' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'didattica',
		'parent_slug'  => 'dsi_options',
		'tab_group'    => 'dsi_options',
		'tab_title'    => __('Pagina "Didattica"', "design_scuole_italia"),	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'dsi_options_display_with_tabs';
	}

    $didattica_options = new_cmb2_box( $args );

    $didattica_landing_url = dsi_get_template_page_url("page-templates/didattica.php");
    $didattica_options->add_field( array(
        'id' => $prefix . 'didattica_istruzioni',
        'name'        => __( 'Sezione Didattica', 'design_scuole_italia' ),
        'desc' => __( 'Inserisci qui le informazioni utili a popolare <a href="'.$didattica_landing_url.'">la pagina di panoramica della Didattica</a>.' , 'design_scuole_italia' ),
        'type' => 'title',
    ) );

    $didattica_options->add_field( array(
        'id' => $prefix . 'testo_didattica',
        'name'        => __( 'Descrizione Sezione', 'design_scuole_italia' ),
        'desc' => __( 'es: "La didattica del liceo scientifico Enriques ' , 'design_scuole_italia' ),
        'type' => 'textarea',
        'attributes'    => array(
            'maxlength'  => '140'
        ),
    ) );


    $didattica_options->add_field( array(
        'id' => $prefix . 'testo_sezione_progetti',
        'name'        => __( 'Descrizione Sezione Progetti', 'design_scuole_italia' ),
        'desc' => __( 'es: "Scopri i progetti della scuola divisi per anno scolastico e per materia' , 'design_scuole_italia' ),
        'type' => 'textarea',
        'attributes'    => array(
            'maxlength'  => '140'
        ),
    ) );

    /**
     * Persone
     */

    $args = array(
        'id'           => 'dsi_options_persone',
        'title'        => esc_html__( 'Le Persone', 'design_scuole_italia' ),
        'object_types' => array( 'options-page' ),
        'option_key'   => 'persone',
        'parent_slug'  => 'dsi_options',
        'tab_group'    => 'dsi_options',
        'tab_title'    => __('Pagina "Persone"', "design_scuole_italia"),	);

    // 'tab_group' property is supported in > 2.4.0.
    if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
        $args['display_cb'] = 'dsi_options_display_with_tabs';
    }

    $persone_options = new_cmb2_box( $args );

    $persone_landing_url = dsi_get_template_page_url("page-templates/persone.php");
    $persone_options->add_field( array(
        'id' => $prefix . 'persone_istruzioni',
        'name'        => __( 'Sezione Persone', 'design_scuole_italia' ),
        'desc' => __( 'Inserisci qui le informazioni utili a popolare <a href="'.$persone_landing_url.'">la pagina delle Persone</a>.' , 'design_scuole_italia' ),
        'type' => 'title',
    ) );


    $persone_options->add_field( array(
        'id' => $prefix . 'testo_sezione_persone',
        'name'        => __( 'Descrizione Sezione Persone', 'design_scuole_italia' ),
        'desc' => __( 'es: "Le persone del liceo scientifico xxx, insegnanti, personale ATA e docenti' , 'design_scuole_italia' ),
        'type' => 'textarea',
        'attributes'    => array(
            'maxlength'  => '140'
        ),
    ) );

    $persone_options->add_field( array(
        'id' => $prefix . 'strutture_persone',
        'name'        => __( 'Seleziona e ordina le strutture organizzative a cui fanno capo le persone', 'design_scuole_italia' ),
        'desc' => __( 'Seleziona le strutture organizzative di cui vuoi mostrare le persone. <a href="'.$persone_landing_url.'">La pagina con la lista delle persone sarà popolata automaticamente</a>. ' , 'design_scuole_italia' ),
        'type'    => 'pw_multiselect',
        'options' => dsi_get_strutture_options(),
        'attributes' => array(
            'placeholder' =>  __( 'Seleziona e ordina le strutture di cui mostrare le persone', 'design_scuole_italia' ),
        ),
    ) );


    // pagina opzioni
	/**
	 * Registers main options page menu item and form.
	 */
	$args = array(
		'id'           => 'dsi_setup_menu',
		'title'        => esc_html__( 'Altro', 'design_scuole_italia' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'setup',
		'tab_group'    => 'dsi_main_options',
		'tab_title'    => __('Altro', "design_scuole_italia"),
		'parent_slug'  => 'dsi_options',
		'tab_group'    => 'dsi_options',

	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'dsi_options_display_with_tabs';
	}

	$setup_options = new_cmb2_box( $args );

    $setup_options->add_field( array(
        'id' => $prefix . 'altro_istruzioni',
        'name'        => __( 'Altre Informazioni', 'design_scuole_italia' ),
        'desc' => __( 'Area di configurazione delle opzioni generali del tema.' , 'design_scuole_italia' ),
        'type' => 'title',
    ) );

	$setup_options->add_field( array(
		'id' => $prefix . 'mapbox_key',
		'name' => 'Access Token MapBox',
		'desc' => __( 'Inserisci l\'access token mapbox per l\'erogazione delle mappe. Puoi crearlo <a target="_blank" href="https://www.mapbox.com/studio/account/tokens/">da qui</a>', 'design_scuole_italia' ),
		'type' => 'text'
    ) );








}
add_action( 'cmb2_admin_init', 'dsi_register_main_options_metabox' );

/**
 * A CMB2 options-page display callback override which adds tab navigation among
 * CMB2 options pages which share this same display callback.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 */
function dsi_options_display_with_tabs( $cmb_options ) {
	$tabs = dsi_options_page_tabs( $cmb_options );
	?>
	<div class="wrap cmb2-options-page option-<?php echo $cmb_options->option_key; ?>">
		<?php if ( get_admin_page_title() ) : ?>
			<h2><?php echo wp_kses_post( get_admin_page_title() ); ?></h2>
		<?php endif; ?>
		<h2 class="nav-tab-wrapper">
			<?php foreach ( $tabs as $option_key => $tab_title ) : ?>
				<a class="nav-tab<?php if ( isset( $_GET['page'] ) && $option_key === $_GET['page'] ) : ?> nav-tab-active<?php endif; ?>" href="<?php menu_page_url( $option_key ); ?>"><?php echo wp_kses_post( $tab_title ); ?></a>
			<?php endforeach; ?>
		</h2>
		<form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo $cmb_options->cmb->cmb_id; ?>" enctype="multipart/form-data" encoding="multipart/form-data">
			<input type="hidden" name="action" value="<?php echo esc_attr( $cmb_options->option_key ); ?>">
			<?php $cmb_options->options_page_metabox(); ?>
			<?php submit_button( esc_attr( $cmb_options->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb' ); ?>
		</form>
	</div>
	<?php
}

/**
 * Gets navigation tabs array for CMB2 options pages which share the given
 * display_cb param.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 *
 * @return array Array of tab information.
 */
function dsi_options_page_tabs( $cmb_options ) {
	$tab_group = $cmb_options->cmb->prop( 'tab_group' );
	$tabs      = array();

	foreach ( CMB2_Boxes::get_all() as $cmb_id => $cmb ) {
		if ( $tab_group === $cmb->prop( 'tab_group' ) ) {
			$tabs[ $cmb->options_page_keys()[0] ] = $cmb->prop( 'tab_title' )
				? $cmb->prop( 'tab_title' )
				: $cmb->prop( 'title' );
		}
	}

	return $tabs;
}



