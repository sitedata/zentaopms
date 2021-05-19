<?php
/**
 * The create storyestimate view of execution module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Liyuchun  <liyuchun@cnezsoft.com>
 * @package     execution
 * @version     $Id
 * @link        http://www.zentao.net
 */
?>
<style>
#showAverage {margin: 0;}
.chosen-container-single .chosen-single div b {top: 8px !important;}
</style>
<?php include '../../common/view/header.html.php';?>
<?php js::set('executionID', $executionID);?>
<?php js::set('storyID', $storyID);?>
<div id='mainContent' class='main-content'>
  <div class="main-header">
    <h2><?php echo $lang->execution->storyEstimate;?></h2>
  </div>
  <div class='btn-toolbar pull-left'>
    <?php if(!empty($rounds)):?>
    <div class='input-group space w-200px'>
      <span class='input-group-addon'><?php echo $lang->execution->selectRound?></span>
      <?php echo html::select('round', $rounds, $round, "class='form-control chosen' onchange='selectRound(this.value)'");?>
    </div>
    <div id='reestimate' class='input-group space w-100px'>
      <?php echo html::a("javascript:showNewEstimate()", $lang->execution->reestimate, '', 'class="btn btn-primary"');?>
    </div>
    <?php endif;?>
  </div>
  <form class='main-form form-ajax' method='post' target='hiddenwin' id="estimateForm">
    <table class='table table-form'>
      <thead>
        <tr class='text-center'>
          <th class='w-120px'><?php echo $lang->execution->team;?></th>
          <th class='w-90px'> <?php echo $lang->story->estimate;?></th>
          <th class='w-90px th-new-estimate hide'><?php echo $lang->execution->newEstimate;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($estimateInfo->estimate)):?>
        <?php foreach($estimateInfo->estimate as $estimate):?>
        <tr class='text-center'>
          <td><?php echo zget($users, $estimate->account);?></td>
          <?php echo html::hidden('account[]', $estimate->account, "class='form-control'");?>
          <td><?php echo $estimate->estimate;?></td>
          <td class='new-estimate hide'><?php echo html::input('estimate[]', '', "class='form-control'");?></td>
        </tr>
        <?php endforeach;?>
        <tr class='text-center'>
          <td><?php echo $lang->execution->average;?></td>
          <td><?php echo $estimateInfo->average;?></td>
          <td class='new-estimate hide'><p id='showAverage'></p></td>
          <?php echo html::hidden('average', '', "class='form-control'");?>
        </tr>
        <?php else:?>
        <?php foreach($team as $user):?>
        <tr class='text-center'>
          <td><?php echo zget($users, $user->account);?></td>
          <?php echo html::hidden('account[]', $user->account, "class='form-control'");?>
          <td class='new-estimate'><?php echo html::input('estimate[]', '', "class='form-control'");?></td>
        </tr>
        <?php endforeach;?>
        <tr class='text-center'>
          <td><strong><?php echo $lang->execution->average;?></strong></td>
          <td><p id='showAverage'></p></td>
          <?php echo html::hidden('average', '', "class='form-control'");?>
        </tr>
        <?php endif;?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan='3' class="text-center form-actions <?php if(!empty($rounds)) echo 'hide';?>">
            <?php echo html::submitButton(); ?>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>
