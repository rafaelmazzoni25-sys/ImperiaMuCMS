/************************************************************************
 Achievements javascript - add by misoka 17.11.2015
 *************************************************************************/
var version = 13;

var stage_count = 0;
var stage_visible = 0;
var stage = {};
var max_stage = 5;

var reqDesc = [];
reqDesc[0] = 'Killing Monsters';  //not used
reqDesc[1] = 'Collect Zen - Enter required Zen';
reqDesc[2] = 'Blood Castle - Enter required points';
reqDesc[3] = 'Devil Square - Enter required points';
reqDesc[4] = 'Chaos Castle - Enter required wins';
reqDesc[5] = 'Collect Items'; //not used
reqDesc[6] = 'Illusion Temple - Enter required player kills';
reqDesc[7] = 'Duels - Enter required wins';
reqDesc[8] = 'Resets - Enter required resets';
reqDesc[9] = 'Grand Resets - Enter required grand resets';
reqDesc[10] = 'Levels - Enter required levels';
reqDesc[11] = 'Master Levels - Enter required master levels';
reqDesc[12] = 'Killing Players - Enter required player kills';
reqDesc[13] = 'Gens - Enter required contribution points';

var rewardDesc = [];
rewardDesc[1] = 'Platinum Coins - set count';
rewardDesc[2] = 'Gold Coins - set count';
rewardDesc[3] = 'Silver Coins - set count';
rewardDesc[4] = 'WCoins - set count';
rewardDesc[5] = 'Goblin Points - set count';
rewardDesc[6] = 'Zen - set count';
rewardDesc[7] = 'Items';    //not used
rewardDesc[8] = 'Level Up Points - set count';
rewardDesc[9] = 'Master Points - set count';


function InitAchievemetsForm()
{
    if(stage_count == 0)
        addEmptyStage();
}

/************************************STAGE*************************************/

function addEmptyStage()
{
    addStage('', [], 0, [], 0);

    var stageId = 'stage'+stage_count;

    setRequirementVisibility(stageId, []);
    setRewardVisibility(stageId);
}

function addStage(description, requirements, reward_type, reward, points)
{
    stage_count++;
    stage_visible++;
    $('#stageCount').val(stage_count);

    var stageId = 'stage'+stage_count;

    stage[stageId] = {};
    stage[stageId]['monster_count'] = 0;
    stage[stageId]['requirements_count'] = 0;
    stage[stageId]['reward_count'] = 0;

    var html = '';

    html += '<div id="'+stageId+'" class="stage">';
    html += '<h3 class="page-header">Stage</h3>';

    html += '<button class="btn btn-danger removeStage" name="'+stageId+'removeStage" onClick="removeStage(\''+stageId+'\'); return false;">Remove stage</button>';

    html += '<table class="table table-striped table-bordered table-hover module_config_tables2">';

    html += '<tr>';
    html += '<th width="30%">Description<br /><span>Write some information about achievement requirements</span></th>';
    html += '<td width="70%"><input class="form-control" type="text" name="'+stageId+'desc" value="'+description+'" style="width:100%"/></td>';
    html += '</tr>';

    html += '<tr>';
    html += '<th>Requirements<br /><span></span></th>';
    html += '<td>';
    html += '<div id="'+stageId+'req0">';
    html += '<span id="'+stageId+'req0desc">Killing Monsters</span><br />';
    html += '<div id="'+stageId+'req0monsters"></div>';
    html += '<button class="btn btn-success" name="'+stageId+'req0addMonster" onClick="addEmptyRequirement0(\''+stageId+'\'); return false;"><i class="fa fa-plus"></i></button>';
    html += '</div>';
    html += '<div id="'+stageId+'req1">';
    html += '<input class="form-control" type="text" name="'+stageId+'req1" id="'+stageId+'req1input" value="0"/>';
    html += '<br /><span id="'+stageId+'req1desc"></span>';
    html += '</div>';
    html += '<div id="'+stageId+'req5">';
    html += '<span id="'+stageId+'req5desc">Collect Items</span><br />';
    html += '<span style="font-weight: normal;font-style: italic;font-size: 11px;">';
    html += 'Valid values<br>';
    html += 'Count: 0-512, Category: 0-15, Index: 0-512, Level: 0-15, Skill: 0/1, Luck: 0/1, Option: 0-7, Excellent: 0-63, Ancient: 0/5/6/9/10';
    html += '</span><br>';
    html += '<div id="'+stageId+'req5items"></div>';
    html += '<button class="btn btn-success" name="'+stageId+'req5addItem" onClick="addEmptyRequirement5(\''+stageId+'\'); return false;"><i class="fa fa-plus"></i></button>';
    html += '</div>';
    html += '</td>';
    html += '</tr>';

    html += '<tr>';
    html += '<th>Reward Type<br /><span>Achievement reward type</span></th>';
    html += '<td>';
    html += '<select name="'+stageId+'rewardType" id="'+stageId+'_rewardType">';
    html += '<option value="1">Platinum Coins</option>';
    html += '<option value="2">Gold Coins</option>';
    html += '<option value="3">Silver Coins</option>';
    html += '<option value="4">WCoins</option>';
    html += '<option value="5">Goblin Points</option>';
    html += '<option value="6">Zen</option>';
    html += '<option value="7">Items</option>';
    html += '<option value="8">Level Up Points</option>';
    html += '<option value="9">Master Points</option>';
    html += '</select>';
    html += '</td>';
    html += '</tr>';

    html += '<tr>';
    html += '<th>Reward<br /><span></span></th>';
    html += '<td>';
    html += '<div id="'+stageId+'reward1">';
    html += '<input class="form-control" type="text" name="'+stageId+'reward1" id="'+stageId+'reward1input" value="0"/>';
    html += '<br /><span id="'+stageId+'reward1desc">Set points</span>';
    html += '</div>';
    html += '<div id="'+stageId+'reward7">';
    html += '<span id="'+stageId+'reward7Desc">';

    html += '<span style="font-weight: normal;font-style: italic;font-size: 11px;">';
    html += 'Valid values<br>';
    html += 'Count: 0-512, Category: 0-15, Index: 0-512, Level: 0-15, Skill: 0/1, Luck: 0/1, Option: 0-7, Excellent: 0-63, Ancient: 0/5/6/9/10';
    html += '</span><br>';
    html += '</span>';

    html += '<div id="'+stageId+'reward7items"></div>';
    html += '<button class="btn btn-success" name="'+stageId+'reward7addItem" onClick="addEmptyReward7(\''+stageId+'\'); return false;"><i class="fa fa-plus"></i></button>';
    html += '</div>';
    html += '</td>';
    html += '</tr>';

    html += '<tr>';
    html += '<th>Points<br /><span>Amount of points for completed stage, used for Achievements Rankings</span></th>';
    html += '<td><input class="form-control" type="text" name="'+stageId+'points" value="'+points+'"/></td>';
    html += '</tr>';

    html += '</table>';
    html += '</div>';

    $('#stages').append(html);

    if(requirements.length > 0)
    {
        setRequirementVisibility(stageId, requirements);
    }

    reward_type = parseInt(reward_type);
    if(reward_type != 0)
    {
        $('#'+stageId+'_rewardType').val(reward_type);

        switch(parseInt(reward_type))
        {
            case 7:
                for(var i = 0; i < reward.length; i++)
                {
                    addReward7(stageId, reward[i]['count'], reward[i]['category'], reward[i]['index'], reward[i]['level'], reward[i]['skill'], reward[i]['luck'], reward[i]['option'], reward[i]['excellent'], reward[i]['ancient']);
                }
                break;
            default: $('#'+stageId+'reward1input').val(reward[1]['points']);
                break;
        }

        setRewardVisibility(stageId);
    }

    setStageButtonsVisibility();

    $('#acv_type').change(function(){
        setRequirementVisibility(stageId, []);
    });

    $('body').on('change', '#'+stageId+'_rewardType', function(){
        setRewardVisibility(stageId);
    });
}

function removeStage(stageId)
{
    if(confirm('Do you really want to delete whole stage?'))
    {
        $('#'+stageId).empty();
        $('#'+stageId).hide();
        stage_visible--;
        setStageButtonsVisibility();
    }
}

function setStageButtonsVisibility()
{
    if(stage_visible >= max_stage)
        $('#add_stage').hide();
    else
        $('#add_stage').show();

    if(stage_visible == 1)
        $('.removeStage').hide();
    else
        $('.removeStage').show();
}

/************************************ITEMS*************************************/

function addItem(divId, itemId, count, category, index, level, skill, luck, option, excellent, ancient)
{
    var html = '';

    html += '<div id="'+divId+'item'+itemId+'" class="'+divId+'_item">';

    html += 'Count: <input class="form-control" style="width:40px;" type="text" name="'+divId+'item_count['+itemId+']" id="'+divId+'item_count'+itemId+'" value="'+count+'"/>';
    html += ' Category: <input class="form-control" style="width:40px;" type="text" name="'+divId+'item_category['+itemId+']" id="'+divId+'item_category'+itemId+'" value="'+category+'"/>';
    html += ' Index: <input class="form-control" style="width:40px;" type="text" name="'+divId+'item_index['+itemId+']" id="'+divId+'item_index'+itemId+'" value="'+index+'"/>';
    html += ' Level: <input class="form-control" style="width:40px;" type="text" name="'+divId+'item_level['+itemId+']" id="'+divId+'item_level'+itemId+'" value="'+level+'"/>';
    html += ' Skill: <input class="form-control" style="width:40px;" type="text" name="'+divId+'item_skill['+itemId+']" id="'+divId+'item_skill'+itemId+'" value="'+skill+'"/>';
    html += ' Luck: <input class="form-control" style="width:40px;" type="text" name="'+divId+'item_luck['+itemId+']" id="'+divId+'item_luck'+itemId+'" value="'+luck+'"/>';
    html += ' Option: <input class="form-control" style="width:40px;" type="text" name="'+divId+'item_option['+itemId+']" id="'+divId+'item_option'+itemId+'" value="'+option+'"/>';
    html += ' Excellent: <input class="form-control" style="width:40px;" type="text" name="'+divId+'item_excellent['+itemId+']" id="'+divId+'item_excellent'+itemId+'" value="'+excellent+'"/>';
    html += ' Ancient: <input class="form-control" style="width:40px;" type="text" name="'+divId+'item_ancient['+itemId+']" id="'+divId+'item_ancient'+itemId+'" value="'+ancient+'"/>';

    html += ' <button class="btn btn-danger" name="'+divId+'removeItem" onClick="removeItem(\''+divId+'item'+itemId+'\'); return false;"> <i class="fa fa-remove"></i></button>';

    html += '</div>';

    $('#'+divId+'items').append(html);
}

function removeItem(divId)
{
    if(confirm('Do you really want to delete the item?'))
    {
        $('#'+divId).empty();
        $('#'+divId).hide();
    }
}

/*****************************REQUIREMENTS*************************************/

function setRequirementVisibility(stageId, requirements)
{
    var typeVal = parseInt($('#acv_type').val());

    switch(typeVal)
    {
        case 0:  //Killing Monsters
            $('#'+stageId+'req0').show();
            $('#'+stageId+'req1').hide();
            $('#'+stageId+'req5').hide();

            //alert('array:'+requirements);
            if(requirements.length != 0)
            {
                //alert('length'+requirements.length);
                for(var i = 0; i < requirements[0].length; i++)
                {
                    //alert('id:'+requirements[0][i]['monsterId']);
                    addRequirement0(stageId, requirements[0][i]['count'], requirements[0][i]['monsterId']);
                }
            }
            else
            {
                if(stage[stageId]['monster_count'] == 0)
                {
                    addEmptyRequirement0(stageId);
                }
            }

            break;
        case 5:  //Collect Items
            $('#'+stageId+'req0').hide();
            $('#'+stageId+'req1').hide();
            $('#'+stageId+'req5').show();

            if(requirements.length != 0)
            {
                for(var i = 0; i < requirements[5].length; i++)
                {
                    addRequirement5(stageId, requirements[5][i]['count'], requirements[5][i]['category'], requirements[5][i]['index'], requirements[5][i]['level'], requirements[5][i]['skill'], requirements[5][i]['luck'], requirements[5][i]['option'], requirements[5][i]['excellent'], requirements[5][i]['ancient']);
                }
            }
            else
            {
                if(stage[stageId]['requirements_count'] == 0)
                {
                    addEmptyRequirement5(stageId);
                }
            }
            break;
        default:
            $('#'+stageId+'req0').hide();
            $('#'+stageId+'req1').show();
            $('#'+stageId+'req5').hide();
            $('#'+stageId+'req1desc').html(reqDesc[typeVal]);

            if(requirements.length != 0)
            {
                $('#'+stageId+'req1input').val(requirements[1]);
            }
            break;
    }
}

function addEmptyRequirement0(stageId)
{
    addRequirement0(stageId, 0,0);
}

function addEmptyRequirement5(stageId)
{
    addRequirement5(stageId, 0,0,0,0,0,0,0,0,0);
}

function addRequirement0(stageId, count, monsterId)
{
    stage[stageId]['monster_count']++;
    var divId = stageId+'req0';
    var itemId = stage[stageId]['monster_count'];
    var html = '';

    html += '<div id="'+divId+'monster'+itemId+'" class="'+divId+'_monster">';

    html += 'Monster ID: <input class="form-control" type="text" name="'+divId+'monster_id['+itemId+']" id="'+divId+'monster_id'+itemId+'" value="'+monsterId+'"/>';
    html += ' Count: <input class="form-control" type="text" name="'+divId+'monster_count['+itemId+']" id="'+divId+'monster_count'+itemId+'" value="'+count+'"/>';

    html += ' <button class="btn btn-danger" name="'+divId+'removeMonster" onClick="removeMonster(\''+divId+'monster'+itemId+'\'); return false;"><i class="fa fa-remove"></i></button>';

    html += '</div>';

    $('#'+divId+'monsters').append(html);
}

function removeMonster(divId)
{
    if(confirm('Do you really want to delete the monster?'))
    {
        $('#'+divId).empty();
        $('#'+divId).hide();
    }
}

function addRequirement5(stageId, count, category, index, level, skill, luck, option, excellent, ancient)
{
    stage[stageId]['requirements_count']++;

    addItem(stageId+'req5', stage[stageId]['requirements_count'], count, category, index, level, skill, luck, option, excellent, ancient);
}

/**********************************REWARDS*************************************/

function setRewardVisibility(stageId)
{
    var typeVal = parseInt($('#'+stageId+'_rewardType').val());

    switch(typeVal)
    {
        case 7:
            $('#'+stageId+'reward1').hide();
            $('#'+stageId+'reward7').show();

            if(stage[stageId]['reward_count'] == 0)
                addEmptyReward7(stageId);

            break;
        default:
            $('#'+stageId+'reward1').show();
            $('#'+stageId+'reward7').hide();
            $('#'+stageId+'reward1desc').html(rewardDesc[typeVal]);
            break;
    }
}

function addEmptyReward7(stageId)
{
    addReward7(stageId, 0,0,0,0,0,0,0,0,0);
}

function addReward7(stageId, count, category, index, level, skill, luck, option, excellent, ancient)
{
    stage[stageId]['reward_count']++;

    addItem(stageId+'reward7', stage[stageId]['reward_count'], count, category, index, level, skill, luck, option, excellent, ancient);
}