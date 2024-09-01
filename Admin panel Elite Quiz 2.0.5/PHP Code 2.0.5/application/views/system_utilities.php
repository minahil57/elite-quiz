<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>System Utility | <?php echo ($app_name) ? $app_name['message'] : "" ?></title>

        <?php base_url() . include 'include.php';?>
    </head>

    <body>


   
        <div id="app">
            <div class="main-wrapper">
                <?php base_url() . include 'header.php';?>




                <!-- Main Content -->
                <div class="main-content">
                    <section class="section">
                        <div class="section-header">
                            <h1>System Utilities <small class="text-small">System utilities for App</small></h1>
                        </div>
                        <div class="section-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">

                                        <div class="card-body mt-4">
                                        <h4>
                                            <label class="control-label"><b>General Settings</b></label>
                                        </h4>    
                                        <form method="post" class="needs-validation" novalidate="">
                                                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
                                                
                                                <div class="form-group row">
                                                    
                                                    
                                                    <div class="col-md-3 col-sm-12">
                                                        
                                                            <label class="control-label">Maximum Winning Coins</label>

                                                            
                                                        <input name="maximum_winning_coins" type="number" class="form-control"  value="<?php echo(!empty($maximum_winning_coins['message']))? $maximum_winning_coins['message'] :"" ?>"required>
                                                    </div>

                                                    <div class="col-md-3 col-sm-12">
                                                        <label class="control-label">Maximum Coins Winning Percentage</label>
                                                        <input name="maximum_coins_winning_percentage" type="number" class="form-control"  value="<?php echo(!empty($maximum_coins_winning_percentage['message']))? $maximum_coins_winning_percentage['message'] :"" ?>"required>
                                                    </div>

                                                    <div class="col-md-3 col-sm-12">
                                                        <label class="control-label">Score</label>
                                                        <input name="score" type="number" class="form-control" value="<?php echo(!empty($score['message']))? $score['message'] :"" ?>" required>
                                                    </div>
                                                    
                                                
                                                    
                                                </div>
                                                <h4>
                                                    <label class="control-label"><b>Time Settings</b></label>
                                                 </h4>    


                                                 <div class="form-group row">
                                                   <div class="col-md-3 col-sm-12">
                                                        <label class="control-label">Quiz Zone Duration</label>
                                                        <input name="quiz_zone_duration" type="text" class="form-control" value="<?php echo(!empty($quiz_zone_duration['message']))? $quiz_zone_duration['message'] :"" ?>" required>
                                                    </div>

                                                    <div class="col-md-3 col-sm-12">
                                                        <label class="control-label">Self Challenge Max Minutes</label>
                                                        <input name="self_challange_max_minutes" type="number"  class="form-control" value="<?php echo(!empty($self_challange_max_minutes['message']))? $self_challange_max_minutes['message'] :"" ?>" required>
                                                    </div>


                                                    <div class="col-md-3 col-sm-12">
                                                        <label class="control-label">Guess The Word Seconds</label>
                                                        <input name="guess_the_word_seconds" type="number" class="form-control" value="<?php echo(!empty($guess_the_word_seconds['message']))? $guess_the_word_seconds['message'] :"" ?>" required>
                                                    </div>



                                                 
                                                </div>
                                                <div class="form-group row">
                                                <div class="col-md-3 col-sm-12">
                                                        <label class="control-label">Maths Quiz Seconds</label>
                                                        <input name="maths_quiz_seconds" type="number" class="form-control" value="<?php echo(!empty($maths_quiz_seconds['message']))? $maths_quiz_seconds['message'] :"" ?>" required>
                                                    </div>


                                                    <div class="col-md-3 col-sm-12">
                                                        <label class="control-label"> Fun & Learn Reading Time In Seconds</label>
                                                        <input name="fun_and_learn_time_in_seconds" type="number" class="form-control" value="<?php echo(!empty($fun_and_learn_time_in_seconds['message']))? $fun_and_learn_time_in_seconds['message'] :"" ?>" required>
                                                    </div>

                                            
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-2 col-sm-6">
                                                        <input type="submit" name="btnadd" value="Submit" class="<?=BUTTON_CLASS?>"/>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <?php base_url() . include 'footer.php';?>

        <script type="text/javascript">
            $(document).ready(function () {
                tinymce.init({
                    selector: '#message',
                    height: 250,
                    menubar: true,
                    plugins: [
                        'advlist autolink lists link charmap print preview anchor textcolor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime table contextmenu paste code help wordcount'
                    ],
                    toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                    setup: function (editor) {
                        editor.on("change keyup", function (e) {
                            editor.save();
                            $(editor.getElement()).trigger('change');
                        });
                    }
                });
            });
        </script>

    </body>
</html>