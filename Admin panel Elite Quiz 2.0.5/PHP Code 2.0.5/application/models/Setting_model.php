<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

    public function get_quiz_list() {
        return $this->db->order_by('id', 'ASC')->get('tbl_quiz_list')->result();
    }

    public function firebase_configurations(){
        $config['upload_path'] = 'assets';
        $config['allowed_types'] = 'json';
        $config['file_name'] = 'firebase_config';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $old_file = 'assets/firebase_config.json';
        if (file_exists($old_file)) {
            unlink($old_file);
        }

        if (!$this->upload->do_upload('file')) {
            return FALSE;
        } else {            
            $data = $this->upload->data();
            return TRUE;
        }
    }



    public function update_system_utility(){
        $settings = [


          'maximum_winning_coins','maximum_coins_winning_percentage','score','quiz_zone_duration',
          'self_challange_max_minutes','guess_the_word_seconds','maths_quiz_seconds',
          'fun_and_learn_time_in_seconds'

            
        ];

    
        foreach ($settings as $type) {
            $message = $this->input->post($type);
            $res = $this->db->where('type', $type)->get('tbl_settings')->row_array();
            if ($res) {
                $data = ['message' => $message];
                $this->db->where('type', $type)->update('tbl_settings', $data);
            } else {
                $data = array(
                    'type' => $type,
                    'message' => $message
                );
                $this->db->insert('tbl_settings', $data);
            }
        }
    }

    public function update_settings() {

        $settings = [
            'system_timezone', 'system_timezone_gmt',
            'app_link', 'more_apps',
            'ios_app_link', 'ios_more_apps',
            'refer_coin', 'earn_coin', 'reward_coin', 'app_version', 'app_version_ios', 'force_update',
            'true_value', 'false_value', 'shareapp_text', 'app_maintenance',
            'answer_mode', 'language_mode', 'option_e_mode', 'daily_quiz_mode', 'contest_mode', 'self_challenge_mode',
            'battle_random_category_mode', 'battle_group_category_mode', 'fun_n_learn_question', 'guess_the_word_question', 'exam_module',
            'fix_question', 'total_question', 'audio_mode_question', 'total_audio_time', 'in_app_purchase_mode',
            'maths_quiz_mode','battle_mode_one','battle_mode_group'
            
        ];

        if(isset($type['coins'])){
            $settings[]='coins';
        }

        if(isset($type['score'])){
            $settings[]='score';
        }
        
        foreach ($settings as $type) {
            $message = $this->input->post($type);
            $res = $this->db->where('type', $type)->get('tbl_settings')->row_array();
            if ($res) {
                $data = ['message' => $message];
                $this->db->where('type', $type)->update('tbl_settings', $data);
            } else {
                $data = array(
                    'type' => $type,
                    'message' => $message
                );
                $this->db->insert('tbl_settings', $data);
            }
        }
    }

    public function update_ads() {
        $settings = [
            'in_app_ads_mode', 'ads_type',
            'android_banner_id', 'android_interstitial_id', 'android_rewarded_id',
            'ios_banner_id', 'ios_interstitial_id', 'ios_rewarded_id',
            'android_fb_banner_id', 'android_fb_interstitial_id', 'android_fb_rewarded_id',
            'ios_fb_banner_id', 'ios_fb_interstitial_id', 'ios_fb_rewarded_id'
        ];

        foreach ($settings as $type) {
            $message = $this->input->post($type);
            $res = $this->db->where('type', $type)->get('tbl_settings')->row_array();
            if ($res) {
                $data = ['message' => $message];
                $this->db->where('type', $type)->update('tbl_settings', $data);
            } else {
                $data = array(
                    'type' => $type,
                    'message' => $message
                );
                $this->db->insert('tbl_settings', $data);
            }
        }
    }

    public function update_profile() {

        $app_name = $this->input->post('app_name');
        $name = $this->db->where('type', 'app_name')->get('tbl_settings')->row_array();
        if ($name) {
            $frm_name = ['message' => $app_name];
            $this->db->where('type', 'app_name')->update('tbl_settings', $frm_name);
        } else {
            $frm_name = array(
                'type' => 'app_name',
                'message' => $app_name
            );
            $this->db->insert('tbl_settings', $frm_name);
        }

        $jwt_key = $this->input->post('jwt_key');
        $j_key = $this->db->where('type', 'jwt_key')->get('tbl_settings')->row_array();
        if ($j_key) {
            $frm_jwt_key = ['message' => $jwt_key];
            $this->db->where('type', 'jwt_key')->update('tbl_settings', $frm_jwt_key);
        } else {
            $frm_jwt_key = array(
                'type' => 'jwt_key',
                'message' => $jwt_key
            );
            $this->db->insert('tbl_settings', $frm_jwt_key);
        }

        $full_url = $this->input->post('full_url');
        $half_url = $this->input->post('half_url');

        if ($_FILES['full_file']['name'] != '' && $_FILES['half_file']['name'] != '') {
            //Full logo upload
            $config = array();
            $config['upload_path'] = LOGO_IMG_PATH;
            $config['allowed_types'] = IMG_ALLOWED_TYPES;
            $config['file_name'] = time();
            $this->load->library('upload', $config, 'fullupload'); // Create custom object for cover upload
            $this->fullupload->initialize($config);

            // half logo upload
            $config1 = array();
            $config1['upload_path'] = LOGO_IMG_PATH;
            $config1['allowed_types'] = IMG_ALLOWED_TYPES;
            $config1['file_name'] = time();
            $this->load->library('upload', $config1, 'halfupload');  // Create custom object for catalog upload
            $this->halfupload->initialize($config1);

            // Check uploads success
            if ($this->fullupload->do_upload('full_file') && $this->halfupload->do_upload('half_file')) {

                // Data of your full logo file
                $full_data = $this->fullupload->data();
                $full_file = $full_data['file_name'];

                if (file_exists($full_url)) {
                    unlink($full_url);
                }

                // Data of your half logo file
                $half_data = $this->halfupload->data();
                $half_file = $half_data['file_name'];

                if (file_exists($half_url)) {
                    unlink($half_url);
                }

                $Flogo = $this->db->where('type', 'full_logo')->get('tbl_settings')->row_array();
                if ($Flogo) {
                    $frm_Flogo = ['message' => $full_file];
                    $this->db->where('type', 'full_logo')->update('tbl_settings', $frm_Flogo);
                } else {
                    $frm_Flogo = array(
                        'type' => 'full_logo',
                        'message' => $full_file
                    );
                    $this->db->insert('tbl_settings', $frm_Flogo);
                }

                $Hlogo = $this->db->where('type', 'half_logo')->get('tbl_settings')->row_array();
                if ($Hlogo) {
                    $frm_Hlogo = ['message' => $half_file];
                    $this->db->where('type', 'half_logo')->update('tbl_settings', $frm_Hlogo);
                } else {
                    $frm_Hlogo = array(
                        'type' => 'half_logo',
                        'message' => $half_file
                    );
                    $this->db->insert('tbl_settings', $frm_Hlogo);
                }
                return TRUE;
            } else {
                return FALSE;
            }
        }

        if ($_FILES['full_file']['name'] != '' && $_FILES['half_file']['name'] == '') {
            $config['upload_path'] = LOGO_IMG_PATH;
            $config['allowed_types'] = IMG_ALLOWED_TYPES;
            $config['file_name'] = time();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('full_file')) {
                return FALSE;
            } else {
                if (file_exists($full_url)) {
                    unlink($full_url);
                }

                $data = $this->upload->data();
                $img = $data['file_name'];
                $logo = $this->db->where('type', 'full_logo')->get('tbl_settings')->row_array();
                if ($logo) {
                    $frm_logo = ['message' => $img];
                    $this->db->where('type', 'full_logo')->update('tbl_settings', $frm_logo);
                } else {
                    $frm_logo = array(
                        'type' => 'full_logo',
                        'message' => $img
                    );
                    $this->db->insert('tbl_settings', $frm_logo);
                }
                return TRUE;
            }
        }

        if ($_FILES['half_file']['name'] != '' && $_FILES['full_file']['name'] == '') {
            $config['upload_path'] = LOGO_IMG_PATH;
            $config['allowed_types'] = IMG_ALLOWED_TYPES;
            $config['file_name'] = time();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('half_file')) {
                return FALSE;
            } else {
                if (file_exists($half_url)) {
                    unlink($half_url);
                }
                $data = $this->upload->data();
                $img = $data['file_name'];
                $logo = $this->db->where('type', 'half_logo')->get('tbl_settings')->row_array();
                if ($logo) {
                    $frm_logo = ['message' => $img];
                    $this->db->where('type', 'half_logo')->update('tbl_settings', $frm_logo);
                } else {
                    $frm_logo = array(
                        'type' => 'half_logo',
                        'message' => $img
                    );
                    $this->db->insert('tbl_settings', $frm_logo);
                }
                return TRUE;
            }
        }
        return TRUE;
    }

    public function delete_multiple($ids, $is_image, $table) {
        if ($is_image) {
            $path = array(
                'tbl_category' => CATEGORY_IMG_PATH,
                'tbl_subcategory' => SUBCATEGORY_IMG_PATH,
                'tbl_question' => QUESTION_IMG_PATH,
                'tbl_notifications' => NOTIFICATION_IMG_PATH,
                'tbl_contest' => CONTEST_IMG_PATH,
                'tbl_contest_question' => CONTEST_QUESTION_IMG_PATH,
                'tbl_audio_question' => QUESTION_AUDIO_PATH,
                'tbl_exam_module_question' => EXAM_QUESTION_IMG_PATH,
                'tbl_maths_question' => MATHS_QUESTION_IMG_PATH,
                'tbl_slider' => SLIDER_IMG_PATH,
            );
            if ($table == 'tbl_audio_question') {
                $query = $this->db->query("SELECT `audio` FROM " . $table . " WHERE id in ( " . $ids . " )");
                $res = $query->result();
                foreach ($res as $audio) {
                    if (!empty($audio->audio) && file_exists($path[$table] . $audio->audio)) {
                        unlink($path[$table] . $audio->audio);
                    }
                }
            } else {
                $query = $this->db->query("SELECT `image` FROM " . $table . " WHERE id in ( " . $ids . " )");
                $res = $query->result();
                foreach ($res as $image) {
                    if (!empty($image->image) && file_exists($path[$table] . $image->image)) {
                        unlink($path[$table] . $image->image);
                    }
                }
            }
        }
        $delete = $this->db->query("DELETE FROM `" . $table . "` WHERE `id` in ( " . $ids . " ) ");
        return $delete ? 1 : 0;
    }   

    public function update_contact_us() {
        $message = $this->input->post('message');
        $data = $this->db->where('type', 'contact_us')->get('tbl_settings')->row_array();
        if ($data) {
            $frm_data = ['message' => $message];
            $this->db->where('type', 'contact_us')->update('tbl_settings', $frm_data);
        } else {
            $frm_data = array(
                'type' => 'contact_us',
                'message' => $message
            );
            $this->db->insert('tbl_settings', $frm_data);
        }
    }

    public function update_terms_conditions() {
        $message = $this->input->post('message');
        $data = $this->db->where('type', 'terms_conditions')->get('tbl_settings')->row_array();
        if ($data) {
            $frm_data = ['message' => $message];
            $this->db->where('type', 'terms_conditions')->update('tbl_settings', $frm_data);
        } else {
            $frm_data = array(
                'type' => 'terms_conditions',
                'message' => $message
            );
            $this->db->insert('tbl_settings', $frm_data);
        }
    }

    public function update_privacy_policy() {
        $message = $this->input->post('message');
        $data = $this->db->where('type', 'privacy_policy')->get('tbl_settings')->row_array();
        if ($data) {
            $frm_data = ['message' => $message];
            $this->db->where('type', 'privacy_policy')->update('tbl_settings', $frm_data);
        } else {
            $frm_data = array(
                'type' => 'privacy_policy',
                'message' => $message
            );
            $this->db->insert('tbl_settings', $frm_data);
        }
    }

    public function update_instructions() {
        $message = $this->input->post('message');
        $data = $this->db->where('type', 'instructions')->get('tbl_settings')->row_array();
        if ($data) {
            $frm_data = ['message' => $message];
            $this->db->where('type', 'instructions')->update('tbl_settings', $frm_data);
        } else {
            $frm_data = array(
                'type' => 'instructions',
                'message' => $message
            );
            $this->db->insert('tbl_settings', $frm_data);
        }
    }

    public function update_about_us() {
        $message = $this->input->post('message');
        $data = $this->db->where('type', 'about_us')->get('tbl_settings')->row_array();
        if ($data) {
            $frm_data = ['message' => $message];
            $this->db->where('type', 'about_us')->update('tbl_settings', $frm_data);
        } else {
            $frm_data = array(
                'type' => 'about_us',
                'message' => $message
            );
            $this->db->insert('tbl_settings', $frm_data);
        }
    }

    public function update_fcm_key() {
        $message = $this->input->post('message');
        $data = $this->db->where('type', 'fcm_server_key')->get('tbl_settings')->row_array();
        if ($data) {
            $frm_data = ['message' => $message];
            $this->db->where('type', 'fcm_server_key')->update('tbl_settings', $frm_data);
        } else {
            $frm_data = array(
                'type' => 'fcm_server_key',
                'message' => $message
            );
            $this->db->insert('tbl_settings', $frm_data);
        }
    }

}
