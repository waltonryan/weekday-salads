<?php
/**
 * Helper functions for the Ingredients module.
 *
 * @package Foodie
 * @since Foodie 1.0
 */

/**
 * Unit Dropdown
 *
 * Create a select menu of units based on the user
 * settings. Can pass a selected value to preselect a
 * certain unit (useful when outputting table in admin area)
 *
 * @since Foodie 1.0
 */
function foodie_unit_selector( $args = array() ) {
	$options = foodie_get_theme_options();
	
	$defaults = array(
		'units'    => foodie_units( $options[ 'unit_system' ] ),
		'selected' => null,
		'name'     => '',
		'id'       => 'unit-dropdown',
		'class'    => 'ingredient-unit',
		'style'    => 'width: 75px;'
	);
	
	$args = wp_parse_args( $args, $defaults );
?>
	<select name="<?php echo $args[ 'name' ]; ?>" id="<?php echo $args[ 'id' ]; ?>" class="<?php echo $args[ 'class' ]; ?>" style="<?php echo $args[ 'style' ]; ?>">
		<?php foreach ( $args[ 'units' ] as $unit => $uni ) : ?>
			<option value="<?php echo $unit; ?>" <?php selected( $unit, $args[ 'selected' ] ); ?>><?php echo $uni[ 'unit' ]; ?></option>
		<?php endforeach; ?>
	</select>
<?php	
};

/**
 * Get a unit
 * 
 * Although output only as singular in the select box, units also
 * have a plural counterpart. All units should be output through
 * this function to properly output the correct unit.
 *
 * @since Foodie 1.0
 */
function foodie_get_unit( $unit, $amount ) {
	$units = foodie_units(	);
	
	return _n( $units[ $unit ][ 'unit' ], $units[ $unit ][ 'plural' ], $amount, 'foodie' );
}

/**
 * Avaiable Units
 *
 * Return an array of avaiable units depending on the preferred
 * unit system. Can be filtered via `foodie_units_$unitsystem`
 *
 * @since Foodie 1.0
 */
function foodie_units( $system = null ) {
	$options = foodie_get_theme_options();
	
	if ( ! $system ) 
		$system = $options[ 'unit_system' ];
		
	if ( 'english' == $system )
		return apply_filters( 'foodie_units_english', array( 
			'unit' => array(
				'unit'   => 'unit',
				'plural' => 'units'
			),
			'lb' => array(
				'unit' => 'lb',
				'plural' => 'lbs'
			),
			'oz' => array(
				'unit' => 'oz',
				'plural' => 'ozs'
			),
			'pt' => array(
				'unit' => 'pt',
				'plural' => 'pts'
			),
			'tsp' => array(
				'unit' => 'tsp',
				'plural' => 'tsps'
			),
			'tbsp' => array(
				'unit' => 'tbsp',
				'plural' => 'tbsps'
			),
			'cup' => array(
				'unit' => 'cup',
				'plural' => 'cups'
			)
		) );
	else
		return apply_filters( 'foodie_units_metric', array( 
			'unit' => array(
				'unit'   => 'unit',
				'plural' => 'units'
			),
			'kg' => array(
				'unit' => 'kg',
				'plural' => 'kgs'
			),
			'g' => array(
				'unit' => 'g',
				'plural' => 'gs'
			),
			'l' => array(
				'unit' => 'l',
				'plural' => 'ls'
			),
			'ml' => array(
				'unit' => 'ml',
				'plural' => 'mls'
			),
			'tsp' => array(
				'unit' => 'tsp',
				'plural' => 'tsps'
			),
			'tbsp' => array(
				'unit' => 'tbsp',
				'plural' => 'tbsps'
			),
			'cup' => array(
				'unit' => 'cup',
				'plural' => 'cups'
			)
		) );
}

/**
 * Avaiable Unit Systems
 *
 * Return an array of avaiable unit systems. There are really
 * only two major, but some people may want more.
 *
 * @since Foodie 1.0
 */
function foodie_unit_systems() {
	return apply_filters( 'foodie_unit_systems', array(
		'metric' => array(
			'system' => 'metric',
			'label'  => 'Metric'
		),
		'english' => array(
			'system' => 'english',
			'label'  => 'English'
		)
	) );
}

/**
 * Display the selected currency.
 *
 * Can be output as the currency sign ($), or as the code (USD)
 *
 * @since Foodie 1.0
 */
function foodie_get_currency( $display = 'sign' ) {
	$options = foodie_get_theme_options();
	$currencies = foodie_currencies();
	
	return $currencies[ $options[ 'currency' ] ][ $display ];
}

/**
 * Avaiable Currencies
 *
 * Return an array of avaiable currencies. Two major are supported,
 * but more can very easily be addded by filtering `foodie_currencies`
 *
 * @since Foodie 1.0
 */
function foodie_currencies() {
	return apply_filters( 'foodie_currencies', array(
		'usd' => array(
			'code' => 'USD',
			'sign' => '&#36;'
		),
		'eur' => array(
			'code' => 'EUR',
			'sign' => '&euro;'
		)
	) );
}