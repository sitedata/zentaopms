<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php
$showSubHeader = $program->category == 'single' ? 'hidden' : 'show';
js::set('showSubHeader', $showSubHeader);
?>
<style> .tabs .tab-pane .table{border: 1px solid #ddd; border-top: none} </style>
<div id="mainContent" class="main-content fade">
  <div class="center-block">
    <div class="main-header">
      <h2><?php echo $lang->design->edit;?></h2>
    </div>
    <form class="load-indicator main-form form-ajax" method='post' enctype='multipart/form-data' id='dataform'>
      <table class="table table-form">
        <tbody>
          <?php if($program->category == 'multiple'):?>
          <tr>
            <th class='w-120px'><?php echo $lang->design->product;?></th>
            <td><?php echo html::select('product', $products, $design->product, "class='form-control chosen'");?></td>
            <td></td>
          </tr>
          <?php endif;?>
          <tr>
            <th class='w-120px'><?php echo $lang->design->story;?></th>
            <td><?php echo html::select('story', empty($stories) ? '' : $stories, $design->story, "class='form-control chosen'");?></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->design->type;?></th>
            <td><?php echo html::select('type', $lang->design->typeList, $design->type, "class='form-control chosen'");?></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->design->name;?></th>
            <td><?php echo html::input('name', $design->name, "class='form-control'");?></td>
            <td></td>
          </tr>
          <tr>
            <th><?php echo $lang->design->desc;?></th>
            <td colspan='2'><?php echo html::textarea('desc', $design->desc, 'class="form-control"');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->design->file;?></th>
            <td colspan='2'><?php echo $this->fetch('file', 'buildform', 'fileCount=1&percent=0.85');?></td>
          </tr>
          <tr>
            <th><?php echo $lang->story->checkAffection;?></th>
            <td colspan='2'>
              <div class='tabs'>
                <ul class='nav nav-tabs'>
                  <li class='active'><a data-toggle='tab' href='#affectedTasks'><?php echo $lang->design->affectedTasks;?><span class='label label-danger label-badge label-circle'><?php echo count($design->tasks);?></span></a></li>
                </ul>
                <div class='tab-content'>
                  <div class='tab-pane active' id='affectedTasks'>
                    <table class='table'>
                      <thead>
                        <tr class='text-center'>
                          <th class='c-id'><?php echo $lang->task->id;?></th>
                          <th class='text-left'><?php echo $lang->task->name;?></th>
                          <th class='w-100px'><?php echo $lang->task->assignedTo;?></th>
                          <th class='c-status'><?php echo $lang->task->status;?></th>
                          <th class='w-100px'><?php echo $lang->task->consumed;?></th>
                          <th class='w-90px'><?php echo $lang->task->left;?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($design->tasks as $task):?>
                        <tr class='text-center'>
                          <td><?php $task->id?></td>
                          <td class='text-left'><?php echo html::a($this->createLink('task', 'view', "taskID=$task->id"), $task->name, '_blank');?></td>;
                          <td><?php echo zget($users, $task->assignedTo);?></td>
                          <td><span class='status-task status-<?php echo $task->status;?>'><?php $this->processStatus('task', $task);?></span></td>
                          <td><?php echo $task->consumed;?></td>
                          <td><?php echo $task->left;?></td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan='3' class='text-center form-actions'><?php echo html::submitButton() . html::backButton();?></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>
<script>
$('#product').change(function()
{
    productID = $(this).val();
    var link = createLink('story', 'ajaxGetProductStories', 'productID=' + productID);
    $.post(link, function(data)
    {
        $('#story').replaceWith(data);
        $('#story_chosen').remove();
        $('#story').chosen();
    })
})

if(showSubHeader == 'hidden') $("#subHeader").remove();
</script>
<?php include '../../common/view/footer.html.php';?>
