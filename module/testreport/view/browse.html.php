<?php
/**
 * The browse view file of testreport module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     testreport
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php if($config->global->flow == 'full'):?>
<div id='mainMenu' class='clearfix'>
  <div class='pull-left btn-toolbar'>
    <span class='btn btn-link btn-active-text'>
      <span class='text'><?php echo $lang->testreport->browse;?></span>
      <span class="label label-light label-badge"><?php echo $pager->recTotal;?></span>
    </span>
  </div>
  <div class='pull-right btn-toolbar'>
    <?php if($objectType == 'product' and $canBeChanged) common::printLink('testreport', 'create', "objectID=0&objectType=testtask&productID=$objectID", "<i class='icon icon-plus'></i> " . $lang->testreport->create, '', "class='btn btn-primary'");?>
  </div>
</div>
<?php endif;?>

<div id='mainContent' class='main-table'>
  <?php if(empty($reports)):?>
  <div class="table-empty-tip">
    <p><span class="text-muted"><?php echo $lang->testreport->noReport;?></span></p>
  </div>
  <?php else:?>
  <table class='table has-sort-head table-fixed' id='reportList'>
    <?php $vars = "objectID=$objectID&objectType=$objectType&extra=$extra&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
    <thead>
      <tr class='text-center'>
        <th class='w-id'>   <?php common::printOrderLink('id',          $orderBy, $vars, $lang->idAB);?></th>
        <th class='text-left'><?php common::printOrderLink('title',     $orderBy, $vars, $lang->testreport->title);?></th>
        <th class='w-90px'> <?php common::printOrderLink('createdBy',   $orderBy, $vars, $lang->openedByAB);?></th>
        <th class='w-150px'><?php common::printOrderLink('createdDate', $orderBy, $vars, $lang->testreport->createdDate);?></th>
        <th class='w-250px text-left'><?php common::printOrderLink('project', $orderBy, $vars, $lang->testreport->execution);?></th>
        <th class='w-250px text-left'><?php echo $lang->testreport->testtask;?></th>
        <th class='c-actions-2'> <?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody class='text-center'>
      <?php foreach($reports as $report):?>
      <tr>
        <?php $viewLink = helper::createLink('testreport', 'view', "reportID=$report->id");?>
        <td><?php echo html::a($viewLink, sprintf('%03d', $report->id), '', "data-app='{$this->app->openApp}'");?></td>
        <td class='text-left' title='<?php $report->title?>'><?php echo html::a($viewLink, $report->title, '', "data-app='{$this->app->openApp}'")?></td>
        <td><?php echo zget($users, $report->createdBy);?></td>
        <td><?php echo substr($report->createdDate, 2);?></td>
        <?php $executionName = $report->execution ? '#' . $report->execution . zget($executions, $report->execution, '') : '';?>
        <td class='text-left' title='<?php echo $executionName?>'><?php echo $executionName;?></td>
        <?php
        $taskName = '';
        foreach(explode(',', $report->tasks) as $taskID) $taskName .= '#' . $taskID . $tasks[$taskID] . ' ';
        ?>
        <td class='text-left' title='<?php echo $taskName?>'><?php echo $taskName;?></td>
        <td class='c-actions'>
          <?php
          if(common::canBeChanged('report', $report))
          {
              common::printIcon('testreport', 'edit', "id=$report->id", '', 'list');
              common::printIcon('testreport', 'delete', "id=$report->id", '', 'list', 'trash', 'hiddenwin');
          }
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <div class='table-footer'><?php $pager->show('right', 'pagerjs');?></div>
  <?php endif;?>
</div>
<?php include '../../common/view/footer.html.php';?>
