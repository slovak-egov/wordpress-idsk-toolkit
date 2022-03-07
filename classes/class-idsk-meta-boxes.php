<?php
/**
 * Meta boxes
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.6.0
 */
namespace IDSK_Toolkit;

if ( !class_exists( 'IDSK_Meta_Boxes' ) ) {
    class IDSK_Meta_Boxes {

        /**
         * Meta boxes array.
         * 
         * @var array
         */
        protected $meta_boxes;

        /**
         * Constructor.
         * 
         * @param array $args
         *   Array of meta boxes to add.
         */
        public function __construct( $args ) {
            $this->meta_boxes = $args;

            add_action( 'plugins_loaded', array( $this, 'loaded' ) );
        }

        /**
         * Loaded function.
         */
        public function loaded() {
            add_action( 'add_meta_boxes', array( $this, 'add' ) );
            add_action( 'save_post', array( $this, 'save' ) );
        }

        /**
         * Add meta boxes.
         */
        public function add() {
            foreach ( $this->meta_boxes as $mbox ) {
                add_meta_box(
                    $mbox['id'],
                    $mbox['title'],
                    array( $this, 'display_html' ),
                    $mbox['post_type'],
                    isset($mbox['context']) ? $mbox['context'] : 'normal',
                    isset($mbox['priority']) ? $mbox['priority'] : 'default',
                    $mbox['args']
                );
            }
        }

        /**
         * Save meta boxes.
         * 
         * @param int $post_id
         *   The post ID.
         */
        public function save( $post_id ) {
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return;
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;

            foreach ( $this->meta_boxes as $mbox ) {
                $mb_id = 'idsktk_'.$mbox['id'];

                if ( !isset( $_POST[$mb_id.'_nonce'] ) || !wp_verify_nonce( $_POST[$mb_id.'_nonce'], '_'.$mb_id.'_nonce' ) )
                    return;

                if ( isset( $mbox['args']['allow'] ) ) { 
                    update_post_meta( $post_id, 'idsktk_allow_'.$mbox['id'], $_POST['idsktk_allow_'.$mbox['id']] );
                }

                if ( isset( $mbox['args']['fields'] ) && isset( $_POST[$mb_id.'_fields'] ) && is_array( $_POST[$mb_id.'_fields'] ) ) {
                    $fields = $mbox['args']['fields'];
                    $inputs = $_POST[$mb_id.'_fields'];
                    $upm = array();

                    if ( isset( $mbox['args']['multiple'] ) && $mbox['args']['multiple'] == true ) {
                        foreach ( $inputs as $i => $item ) {
                            $upm[] = $this->sanitize_input_values( $item, $fields );
                        }
                    } else {
                        $upm = $this->sanitize_input_values( $inputs, $fields );
                    }
                    
                    update_post_meta( $post_id, $mb_id.'_fields', $upm );
                }
            }
        }
        
        /**
         * Get meta box value.
         *
         * @param string $value
         *   Meta box key.
         * 
         * @return bool|mixed|string
         */
        protected function get_meta( $value ) {
            global $post;

            $field = get_post_meta( $post->ID, $value, TRUE );
            if ( !empty( $field ) ) {
                return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
            } else {
                return FALSE;
            }
        }

        /**
         * Sanitize inputed values.
         * 
         * @param array $inputs
         *   Array of inputs to be sanitized.
         * @param array $fields
         *   Array of fields settings.
         * 
         * @return array
         *   Array of sanitized inputs.
         */
        protected function sanitize_input_values( $inputs, $fields ) {
            $values = array();

            foreach ( $inputs as $key => $value ) {
                $sanitized_value = null;

                switch ( $fields[$key]['type'] ) {
                    case 'textarea':
                        $sanitized_value = sanitize_textarea_field( $value );
                        break;
                    case 'url':
                        $sanitized_value = sanitize_url( $value );
                        break;
                    default:
                        $sanitized_value = sanitize_text_field( $value );
                        break;
                }

                $values[$key] = $sanitized_value;
            }

            return $values;
        }

        /**
         * Display meta box HTML.
         * 
         * @param \WP_Post $post
         *   Post object.
         * @param array $mbox
         *   Meta box array.
         */
        public function display_html( $post, $mbox ) {
            $mb_id = 'idsktk_'.$mbox['id'];
            $is_multiple = isset( $mbox['args']['multiple'] ) && $mbox['args']['multiple'] == true ? true : false;
            $fields = isset( $mbox['args']['fields'] ) ? $mbox['args']['fields'] : array();
            $output = '';

            wp_nonce_field( '_'.$mb_id.'_nonce', $mb_id.'_nonce' );

            if ( isset( $mbox['args']['allow'] ) && $mbox['args']['allow'] != '' ) {
                $output .= $this->allow_option( $mbox );
            }

            if ( !empty( $fields ) ) {
                $datas = $this->get_meta( $mb_id.'_fields' );

                if ( empty($datas) ) {
                    foreach ($fields as $key => $field) {
                        if ( $is_multiple ) {
                            $datas[0][$key] = '';
                        } else {
                            $datas[$key] = '';
                        }
                    }
                }

                if ( $is_multiple ) {
                    $i = 0;

                    foreach ($datas as $data) {
                        $output .= '<div class="idsk-meta-single">';
                        $output .= $this->render_fields( $mb_id.'_fields['.$i.']', $fields, $data, '', '&nbsp;' );
                        $output .= '<a class="button button-primary idsk-meta-remove" href="#" title="' . esc_attr__( 'Delete entry', 'idsk-toolkit' ) . '" style="background-color: red; vertical-align: middle;">' . esc_html__( 'Delete entry', 'idsk-toolkit' ) . '</a>';
                        $output .= '<hr />';
                        $output .= '</div>';

                        $i++;
                    }
                    
                    $output .= '<div>
                            <a class="button button-primary idsk-meta-add" href="#" title="' . esc_attr__( 'Add entry', 'idsk-toolkit' ) . '">' . esc_html__( 'Add entry', 'idsk-toolkit' ) . '</a>
                        </div>';
                } else {
                    $output .= $this->render_fields( $mb_id.'_fields', $fields, $datas, '<p>', '</p>' );
                }
            }

            echo $output;
        }

        /**
         * Display allow option.
         * 
         * @param array $mbox
         *   Meta box array.
         * 
         * @return string
         */
        protected function allow_option( $mbox ) {
            $allowed = $this->get_meta( 'idsktk_allow_'.$mbox['id'] );

            $output = '<div>
                    <label for="idsktk_allow_'.esc_attr($mbox['id']).'">
                        <input name="idsktk_allow_'.esc_attr($mbox['id']).'" id="idsktk_allow_'.esc_attr($mbox['id']).'" type="checkbox" '.( $allowed != '' ? 'checked="checked"' : '' ).' />
                        ' . esc_html($mbox['args']['allow']) . '
                    </label>
                </div>';

            return $output;
        }

        /**
         * Render input fields.
         * 
         * @param int $id
         *   Fields ID.
         * @param array $fields
         *   Fields array.
         * @param array $defaults
         *   Fields default values array.
         * @param string $beforeHTML
         *   HTML before each field.
         * @param string $afterHTML
         *   HTML after each field.
         * 
         * @return string
         */
        protected function render_fields( $id, $fields, $defaults = array(), $beforeHTML = null, $afterHTML = null ) {
            $output = '';

            foreach ( $fields as $key => $data ) {
                $iid = $id.'['.$key.']';
                $value = null;

                if ( !empty($defaults) ) {
                    $value = $defaults[$key];
                }

                if ( !is_null( $beforeHTML ) ) {
                    $output .= $beforeHTML;
                }

                switch ($data['type']) {
                    case 'textarea':
                        $output .= $this->input_textarea( $iid, $data, $value );
                        break;
                    case 'select_posts':
                        $args = array();
                        $args_posts = array(
                            'post_type'         => 'post',
                            'orderby'           => 'publish_date',
                            'posts_per_page'    => -1
                        );

                        foreach ( get_posts( $args_posts ) as $spost ) { 
                            $args[] = array(
                                'value' => $spost->ID,
                                'name'  => get_the_title($spost->ID)
                            );
                        }

                        $output .= $this->input_select( $iid, $data, $args, $value );
                        break;
                    default:
                        $output .= $this->input_text( $iid, $data, $value );
                        break;
                }

                if ( !is_null( $afterHTML ) ) {
                    $output .= $afterHTML;
                }
            }

            return $output;
        }

        /**
         * Display text input.
         * 
         * @param string $id
         *   Input ID.
         * @param array $mbox
         *   Meta box array.
         * @param string $type
         *   Input type.
         * @param string $value
         *   Input value.
         * 
         * @return string
         */
        protected function input_text( $id, $mbox, $value = null ) {
            return '<label for="' . esc_attr($id) . '">
                    ' . esc_html($mbox['title']) . '
                    <input
                        name="' . esc_attr($id) . '"
                        id="' . esc_attr($id) . '"
                        type="' . esc_attr(isset($mbox['type']) ? $mbox['type'] : 'text') . '"
                        value="' . esc_attr(!is_null($value) ? $value : $this->get_meta($id)) . '"
                    />
                </label>';
        }

        /**
         * Display textarea input.
         * 
         * @param string $id
         *   Input ID.
         * @param array $mbox
         *   Meta box array.
         * @param string $value
         *   Input value.
         * 
         * @return string
         */
        protected function input_textarea( $id, $mbox, $value = null ) {
            return '<label for="' . esc_attr($id) . '">
                    ' . esc_html($mbox['title']) . '
                    <textarea
                        name="' . esc_attr($id) . '"
                        id="' . esc_attr($id) . '"
                        rows="3"
                        cols="60"
                        style="vertical-align: middle;"
                    >' . esc_html(!is_null($value) ? $value : $this->get_meta($id)) . '</textarea>
                </label>';
        }

        /**
         * Display select input.
         * 
         * @param string $id
         *   Input ID.
         * @param array $mbox
         *   Meta box array.
         * @param array $args
         *   Select options array.
         * @param string $value
         *   Selected value.
         * 
         * @return string
         */
        protected function input_select( $id, $mbox, $args = array(), $value = null ) {
            $selected = !is_null($value) ? $value : $this->get_meta($id);

            $output = '<label for="' . esc_attr($id) . '">' . esc_html($mbox['title']) . '</label>
                <select name="' . esc_attr($id) . '" id="' . esc_attr($id) . '">';

            if ( isset( $mbox['option_none'] ) ) {
                $output .= '<option value="">' . esc_html($mbox['option_none']) . '</option>';
            }

            foreach ( $args as $item ) {
                $output .= '<option value="' . $item['value'] . '" ' . ( $selected == $item['value'] ? 'selected="selected"' : '' ) . '>' . esc_html($item['name']) . '</option>';
            }

            $output .= '</select>';

            return $output;
        }
    }
}