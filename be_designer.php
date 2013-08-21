<?php
include('lib/func.designevent.php');
$latestEventRow = getLatestEvent();
$eventsRes = getEvent_info();
?>

<div class="body_internal_wrapper">
    <!--detail_page_heading-->
    <div class="detail_page_heading">
        Submit a design and we’ll sell the best ones!
    </div><!--detail_page_heading-->
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] == "succ") {
        if (isset($_GET['str']))
            echo "<div class='alert_success'><div>" . base64_decode($_GET['str']) . "</div></div>";
    }
    elseif (isset($_GET['msg']) && $_GET['msg'] == 'err') {
        if (isset($_GET['str']))
            echo "<div class='alert_err'><div>" . base64_decode($_GET['str']) . "</div></div>";
    }
    ?>
    <!--be_a_designer_detail-->
    <div class="beadesigner_img_wrapp">
        <img src="images/be_a_designer.png" />
        <div class="beadesigner_text">
            <span class="beadesigner"><?php echo $latestEventRow['event_title']; ?></span>
            <br />
            <p> <?php echo $latestEventRow['description']; ?> </p>
            <span class="beadesigner">Winner Prize: $<?php echo $latestEventRow['prize']; ?>
        </div>
    </div><!--be_a_designer_detail-->
    <!--detail_page_heading-->
    <div class="detail_page_heading">
        Upcoming Events
    </div><!--detail_page_heading-->
    <!--events_table-->
    <div class="beadesigner_events">
        <div class="beadesigner_events_table">
            <table width="764" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th width="185">Event</th>
                    <th width="126">Description</th>
                    <th width="119">Start Date</th>
                    <th width="153">End Date</th>
                    <th width="181">Winner Prize</th>
                    <th width="181">Submit Design</th>
                </tr>
                    <?php
                    $i = 0;
                    while ($row = mysql_fetch_array($eventsRes)) {
                        ?>
                        <tr>
                            <td width="20%" id="eventTitle_<?php echo $row['event_id']; ?>"><?php echo $row['event_title']; ?></td>
                            <td  align="center" width="30%">
                                <span><?php echo substr($row['description'], 0, 100) . '...'; ?> </span>
                                <span id="eventDesc_<?php echo $row['event_id']; ?>" style="display:none"><?php echo $row['description']; ?> </span>
                            </td>
                            <td  align="center" width="10%"> <span style="float:none"><?php echo date('dM-Y', strtotime($row['start_date'])); ?> </span></td>
                            <td  align="center" width="10%"> <span style="float:none"><?php echo date('dM-Y', strtotime($row['end_date'])); ?> </span></td>
                            <td  align="center" width="10%" id="eventPrize_<?php echo $row['event_id']; ?>">$<?php echo $row['prize']; ?></td>
                            <td  align="center" width="20%"><a href='javascript:;' class="design_popup" id="<?php echo $row['event_id']; ?>"><img src="images/btn_upload.png" border="0"></a></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    if ($i == 1)
                        echo "<tr><td colspan='6'> (There is no event yet, keep visiting to be updated.) </td></tr>"
                    ?>
            </table>
        </div>
    </div><!--events_table-->
    <!--detail_page_heading-->
    <div class="detail_page_heading">
        Want to get your work noticed?
    </div><!--detail_page_heading-->
    <!--be_a_designer_detail-->
    <div class="beadesigner_img_wrapp">
        At Send With Style, we strive to offer fun and unique designs to our customers. We need your help to provide us with great designs for our invitations and save the date cards. In addition to getting your design promoted on our website, you can make an 8% commission on sales of the design!
    </div><!--be_a_designer_detail-->
</div><!--body_internal_wrapp-->
</div><!--body_conetnt-->
<div id="event_upload_modal_content" style="display:none">
    <div class="popup_eventTitle" style="float:left"> </div>
    <div class="prizeContent" style="float:right; ">
        <div style="font-family:impact; font-size:12px; color:#666">Prize</div>
        <div style="font-family:impact; font-size:15px;" id="popup_eventPrize"></div>
    </div>
    <div class="prizeHyphen" style="float:right;font-family:impact; font-size:26px; margin-right:10px; color:#666">-</div>
    <img src="images/event_popup_shadow_cropped.jpg">
    <div class="popup_eventDesc"></div>
    <div style="border:1px solid #aaa; background-color: #ddd; padding:10px; margin-top:10px">
        <div style="color:#29748C; margin-top:0px"><b>Submit your Design</b>
        </div>
        <form id="eventForm" name="eventForm" action="do_save_event_design.php" method="post" style="margin-left:15px" enctype="multipart/form-data">
            <table border="0" cellpadding="4" cellspacing="0">
                <tr>
                    <td>First Name</td><td><input type="text" name="fNameTxt" id="fNameTxt"></td>
                </tr>
                <tr>
                    <td>Last Name</td><td><input type="text" name="lNameTxt" id="lNameTxt"></td>
                </tr>
                <tr>
                    <td>Email</td><td><input type="text" name="emailTxt" id="emailTxt"></td>
                </tr>
                <tr>
                    <td>Phone</td><td><input type="text" name="phoneTxt" id="phoneTxt"></td>
                </tr>
                <tr>
                    <td>Select Design</td><td><input type="file" name="designFile" id="designFile"></td>
                </tr>
                <tr>
                    <td> <input type="hidden" name="popup_event_id"  id="popup_event_id" value=""></td>
                    <td><button style="border:none; background:none"><img src="images/btn_submit.png"></button></td>
                </tr>
            </table>
        </form>
    </div>
    <div style="font-size: 10px; margin-top: 15px">Note: You will be notified through email / phone in case if your design gets selected as winning design. You could submit multiple designs so you could sit back could prepare more quality designs to increase your winning chances.</div>
</div>