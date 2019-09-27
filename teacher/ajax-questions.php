<?php
session_start();
ob_start();

include "config.php";
if (isset($_GET['qtype'])){
    $questionType = $_GET['qtype'];
}
else{
    exit;
}
?>

<div class="row">
    <div class="col-md-12">
        <?php if($questionType == 'One or Two words') {
            ?>
            <div class="form-group">
                <div class="col-lg-5">
                    <label>Question</label>
                </div>
                <div class="col-lg-6">
                    <label>Answer</label>
                </div>
            </div>
            <div class="form-group ques-ans-row">
                <div class="row">
                    <div class="col-lg-5">
                        <input type="hidden" class="form-control" name="quesansId[0]">
                        <textarea name="quesword0" class="form-control" placeholder="Question"></textarea>
                    </div>
                    <div class="col-lg-6">
                        <textarea name="answord0" class="form-control" placeholder="answer"></textarea>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-info add-ques-ans" title="Add More">+</button>
                    </div>
                </div>
            </div>
        <?php
        }
        else if($questionType == 'Choose'){
            ?>
            <div class="form-group hidden">
                <div class="col-lg-2">
                    <label>Question</label>
                </div>
                <div class="col-lg-2">
                    <label>Option A</label>
                </div>
                <div class="col-lg-2">
                    <label>Option B</label>
                </div>
                <div class="col-lg-2">
                    <label>Option C</label>
                </div>
                <div class="col-lg-2">
                    <label>Option D</label>
                </div>
                <div class="col-lg-2">
                    <label>Answer</label>
                </div>
            </div>
            <div class="form-group choose-row">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-lg-10">
                        <input type="hidden" class="form-control" name="chooseId[0]">
                        <input type="text" class="form-control" name="chooseques0" placeholder="Question"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="optiona0" placeholder="Option A"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="optionb0" placeholder="Option B"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="optionc0" placeholder="Option C"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="optiond0" placeholder="Option D"/>
                    </div>
                    <div class="col-lg-1">
                        <label style="float: right;">Ans:</label>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" name="chooseans0" placeholder="Answer"/>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-info add-choose" title="Add More">+</button>
                    </div>
                </div>
                </br>
            </div>
        <?php
        }
        else{
            ?>
            <div class="form-group">
                <div class="col-lg-5">
                    <label>Question</label>
                </div>
                <div class="col-lg-6">
                    <label>Answer</label>
                </div>
            </div>
            <div class="form-group question-row">
                <div class="row">
                    <div class="col-lg-5">
                        <input type="hidden" class="form-control" name="questionId[0]">
                        <input type="text" class="form-control" name="question0" placeholder="Question"/>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="answer0" placeholder="answer"/>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-info add-question" title="Add More">+</button>
                    </div>
                </div>
            </div>
        <?php
        }?>


        <script>
            $(function(){
                var counter = 1;
                $('.add-question').click(function(event){
                    event.preventDefault();

                    var newRow = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="questionId['+
                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="question' +
                    counter + '"/> </div> <div class="col-lg-6"> <input type="text" class="form-control" placeholder="answer" name="answer' +
                    counter + '"/> </div> </div>');
                    counter++;
                    $('.question-row').append(newRow);
                });
            });

            $(function(){
                var counter = 1;
                $('.add-choose').click(function(event){
                    event.preventDefault();

                    var newRow = $('<div class="row" style="margin-bottom:10px;"> <div class="col-lg-10"> <input type="hidden" class="form-control" name="chooseId['+
                    counter + ']" /><input type="text" class="form-control" placeholder="Question" name="chooseques' +
                    counter + '"/> </div> </div> <div class="row"><div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option A" name="optiona' +
                    counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option B" name="optionb' +
                    counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option C" name="optionc' +
                    counter + '"/> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Option D" name="optiond' +
                    counter + '"/> </div> <div class="col-lg-1"> <label style="float: right;">Ans:</label> </div> <div class="col-lg-2"> <input type="text" class="form-control" placeholder="Answer" name="chooseans' +
                    counter + '"/> </div> </div> </br>');
                    counter++;
                    $('.choose-row').append(newRow);
                });
            });

            $(function(){
                var counter = 1;
                $('.add-ques-ans').click(function(event){
                    event.preventDefault();

                    var newRow = $('<div class="row"> <div class="col-lg-5"> <input type="hidden" class="form-control" name="quesansId['+
                    counter + ']" /><textarea class="form-control" placeholder="question" name="quesword' +
                    counter + '"></textarea> </div> <div class="col-lg-6"> <textarea class="form-control" placeholder="answer" name="answord' +
                    counter + '"> </textarea> </div> </div>');
                    counter++;
                    $('.ques-ans-row').append(newRow);
                });
            });
        </script>

        <div class="form-group">
            <input type="hidden" name="question_bank_id" value="<?php echo $questionbank_id; ?>" />
            <div class="col-lg-2">
                <input type="submit" value="OK" class="btn btn-info form-control"/>
            </div>
        </div>
    </div>
</div>
