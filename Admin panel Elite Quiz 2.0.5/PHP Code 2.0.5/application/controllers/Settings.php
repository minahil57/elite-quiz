<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set(get_system_timezone());

        $this->result['full_logo'] = $this->db->where('type', 'full_logo')->get('tbl_settings')->row_array();
        $this->result['half_logo'] = $this->db->where('type', 'half_logo')->get('tbl_settings')->row_array();
        $this->result['app_name'] = $this->db->where('type', 'app_name')->get('tbl_settings')->row_array();

        $this->result['system_key'] = $this->db->where('type', 'system_key')->get('tbl_settings')->row_array();
        $this->result['configuration_key'] = $this->db->where('type', 'configuration_key')->get('tbl_settings')->row_array();
    } 
    
    public function firebase_configurations(){
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!has_permissions('read', 'firebase_configurations')) {
                redirect('/', 'refresh');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('update', 'firebase_configurations')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $data = $this->Setting_model->firebase_configurations();
                        if ($data == FALSE) {
                            $this->session->set_flashdata('error', 'Only json file allow..!');
                        } else {
                            $this->session->set_flashdata('success', 'Configurations Update successfully.!');
                        }                       
                    }
                    redirect('firebase-configurations', 'refresh');
                }

                $this->load->view('firebase_configurations', $this->result);
            }
        }
    }





    public function system_utilities(){
       

        if ($this->input->post('btnadd')) {
            $this->Setting_model->update_system_utility();
            $this->session->set_flashdata('success', 'Settings Update successfully.! ');
      
        redirect('system-utilities', 'refresh');
        }

        $settings = [
            
            'maximum_winning_coins','maximum_coins_winning_percentage','score','quiz_zone_duration',
            'self_challange_max_minutes','guess_the_word_seconds','maths_quiz_seconds',
            'fun_and_learn_time_in_seconds'
        ];
        foreach ($settings as $row) {
            $data = $this->db->where('type', $row)->get('tbl_settings')->row_array();
            $this->result[$row] = $data;
        }

        // print_r($this->result);
        // return false;
        $this->load->view('system_utilities', $this->result);

    }

    public function system_configurations() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {            
            if (!has_permissions('read', 'system_configuration')) {
                redirect('/', 'refresh');
            } else {
                if ($this->input->post('btnadd')) {
                    // if (!has_permissions('update', 'system_configuration')) {
                    //     $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    // } else {
                        $this->Setting_model->update_settings();
                        $this->session->set_flashdata('success', 'Settings Update successfully.! ');
                    // }
                    redirect('system-configurations', 'refresh');
                }



                $settings = [
                    'system_timezone', 'system_timezone_gmt',
                    'app_link', 'more_apps',
                    'ios_app_link', 'ios_more_apps',
                    'refer_coin', 'earn_coin', 'reward_coin', 'app_version', 'app_version_ios', 'force_update',
                    'true_value', 'false_value', 'shareapp_text', 'app_maintenance',
                    'answer_mode', 'language_mode', 'option_e_mode', 'daily_quiz_mode', 'contest_mode', 'self_challenge_mode',
                    'battle_random_category_mode', 'battle_group_category_mode', 'fun_n_learn_question', 'guess_the_word_question', 'exam_module',
                    'fix_question', 'total_question', 'audio_mode_question', 'total_audio_time', 'in_app_purchase_mode',
                    'maths_quiz_mode', 'battle_mode_one','battle_mode_group'
                ];
                foreach ($settings as $row) {
                    $data = $this->db->where('type', $row)->get('tbl_settings')->row_array();
                    $this->result[$row] = $data;
                }

                $this->load->view('system_configurations', $this->result);
            }
        }
    }

    public function ads_settings() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!has_permissions('read', 'ads_settings')) {
                redirect('/', 'refresh');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('update', 'ads_settings')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $this->Setting_model->update_ads();
                        $this->session->set_flashdata('success', 'Settings Update successfully.!');
                    }
                    redirect('ads-settings', 'refresh');
                }

                $settings = [
                    'in_app_ads_mode', 'ads_type',
                    'android_banner_id', 'android_interstitial_id', 'android_rewarded_id',
                    'ios_banner_id', 'ios_interstitial_id', 'ios_rewarded_id',
                    'android_fb_banner_id', 'android_fb_interstitial_id', 'android_fb_rewarded_id',
                    'ios_fb_banner_id', 'ios_fb_interstitial_id', 'ios_fb_rewarded_id',
                    'android_game_id', 'ios_game_id',
                ];
                foreach ($settings as $row) {
                    $data = $this->db->where('type', $row)->get('tbl_settings')->row_array();
                    $this->result[$row] = $data;
                }

                $this->load->view('ads_settings', $this->result);
            }
        }
    }

    public function profile() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            if (!$this->session->userdata('authStatus')) {
                redirect('/');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('create', 'profile')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $data = $this->Setting_model->update_profile();
                        if ($data == FALSE) {
                            $this->session->set_flashdata('error', IMAGE_ALLOW_MSG);
                        } else {
                            $this->session->set_flashdata('success', 'Profile update successfully.! ');
                        }
                    }
                    redirect('profile', 'refresh');
                }
                $this->result['jwt_key'] = $this->db->where('type', 'jwt_key')->get('tbl_settings')->row_array();
                $this->load->view('profile', $this->result);
            }
        }
    }


    public function send_notifications() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!has_permissions('read', 'send_notification')) {
                redirect('/', 'refresh');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('create', 'send_notification')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $users = $this->input->post('users');
                        if ($users === 'selected') {
                            if ($this->input->post('selected_list') == '') {
                                $this->session->set_flashdata('error', 'Please Select the users from the table..');
                            } else {
                                $this->Notification_model->add_notification();
                                $this->session->set_flashdata('success', 'Notification Sent Successfully..');
                            }
                        } else {
                            $this->Notification_model->add_notification();
                            $this->session->set_flashdata('success', 'Notification Sent Successfully..');
                        }
                    }
                    redirect('send-notifications', 'refresh');
                }
                $this->result['category'] = $this->Category_model->get_data(1);
                $this->load->view('notifications', $this->result);
            }
        }
    }

    public function delete_notification() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!has_permissions('delete', 'send_notification')) {
                echo FALSE;
            } else {
                $id = $this->input->post('id');
                $image_url = $this->input->post('image_url');
                $this->Notification_model->delete_notification($id, $image_url);
                echo "Notification deleted successfully..";
            }
        }
    }


    public function play_store_contact_us() {
        $result['setting'] = $this->db->where('type', 'contact_us')->get('tbl_settings')->row_array();
        $this->load->view('play_store_contact_us', $result);
    }

    public function contact_us() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!$this->session->userdata('authStatus')) {
                redirect('/');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('create', 'contact_us')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $this->Setting_model->update_contact_us();
                        $this->session->set_flashdata('success', 'Contact Us updated successfully.!');
                    }
                    redirect('contact-us', 'refresh');
                }
                $this->result['setting'] = $this->db->where('type', 'contact_us')->get('tbl_settings')->row_array();
                $this->load->view('contact_us', $this->result);
            }
        }
    }

    public function play_store_terms_conditions() {
        $result['setting'] = $this->db->where('type', 'terms_conditions')->get('tbl_settings')->row_array();
        $this->load->view('play_store_terms_conditions', $result);
    }

    public function terms_conditions() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!$this->session->userdata('authStatus')) {
                redirect('/');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('create', 'terms_conditions')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $this->Setting_model->update_terms_conditions();
                        $this->session->set_flashdata('success', 'Terms Conditions updated successfully.!');
                    }
                    redirect('terms-conditions', 'refresh');
                }
                $this->result['setting'] = $this->db->where('type', 'terms_conditions')->get('tbl_settings')->row_array();
                $this->load->view('terms_conditions', $this->result);
            }
        }
    }

    public function play_store_privacy_policy() {
        $result['setting'] = $this->db->where('type', 'privacy_policy')->get('tbl_settings')->row_array();
        $this->load->view('play_store_privacy_policy', $result);
    }

    public function privacy_policy() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!$this->session->userdata('authStatus')) {
                redirect('/');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('create', 'privacy_policy')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $this->Setting_model->update_privacy_policy();
                        $this->session->set_flashdata('success', 'Privacy Policy updated successfully.!');
                    }
                    redirect('privacy-policy', 'refresh');
                }
                $this->result['setting'] = $this->db->where('type', 'privacy_policy')->get('tbl_settings')->row_array();
                $this->load->view('privacy_policy', $this->result);
            }
        }
    }

    public function instructions() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!$this->session->userdata('authStatus')) {
                redirect('/');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('create', 'instructions')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $this->Setting_model->update_instructions();
                        $this->session->set_flashdata('success', 'Instructions updated successfully.!');
                    }
                    redirect('instructions', 'refresh');
                }
                $this->result['setting'] = $this->db->where('type', 'instructions')->get('tbl_settings')->row_array();
                $this->load->view('instructions', $this->result);
            }
        }
    }

    public function about_us() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!$this->session->userdata('authStatus')) {
                redirect('/');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('create', 'about_us')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $this->Setting_model->update_about_us();
                        $this->session->set_flashdata('success', 'About Us updated successfully.!');
                    }
                    redirect('about-us', 'refresh');
                }
                $this->result['setting'] = $this->db->where('type', 'about_us')->get('tbl_settings')->row_array();
                $this->load->view('about_us', $this->result);
            }
        }
    }

    public function notification_settings() {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('/');
        } else {
            if (!$this->session->userdata('authStatus')) {
                redirect('/');
            } else {
                if ($this->input->post('btnadd')) {
                    if (!has_permissions('create', 'notification_settings')) {
                        $this->session->set_flashdata('error', PERMISSION_ERROR_MSG);
                    } else {
                        $this->Setting_model->update_fcm_key();
                        $this->session->set_flashdata('success', 'Updated successfully.!');
                    }
                    redirect('notification-settings', 'refresh');
                }
                $this->result['setting'] = $this->db->where('type', 'fcm_server_key')->get('tbl_settings')->row_array();
                $this->load->view('notification_settings', $this->result);
            }
        }
    }

    public function upload_img() {
        $accepted_origins = array("http://" . $_SERVER['HTTP_HOST']);

        if (!is_dir('images/instruction')) {
            mkdir('images/instruction', 0777, true);
        }
        $imageFolder = "images/instruction/";

        reset($_FILES);
        $temp = current($_FILES);
        if (is_uploaded_file($temp['tmp_name'])) {
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                // Same-origin requests won't set an origin. If the origin is set, it must be valid.
                if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                } else {
                    header("HTTP/1.1 403 Origin Denied");
                    return;
                }
            }

            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $filename = $temp['name'];

            $filetype = $_POST['filetype']; // file type
            // Valid extension
            if ($filetype == 'image') {
                $valid_ext = array('png', 'jpeg', 'jpg');
            } else if ($filetype == 'media') {
                $valid_ext = array('mp4', 'mp3');
            }

            $location = $imageFolder . $temp['name'];   // Location

            $file_extension = pathinfo($location, PATHINFO_EXTENSION); // file extension
            $file_extension = strtolower($file_extension);

            $return_filename = "";

            // Check extension
            if (in_array($file_extension, $valid_ext)) {
                // Upload file
                if (move_uploaded_file($temp['tmp_name'], $location)) {
                    $return_filename = $filename;
                }
            }

            echo $return_filename;
        } else {
            header("HTTP/1.1 500 Server Error");  // Notify editor that the upload failed
        }
    }

}
