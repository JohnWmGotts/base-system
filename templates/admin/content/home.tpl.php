<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
	<td class="title-bg">Home</td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
  </tr>
  <tr>
	<td width="10" align="left" class="content-left-bg"></td>
	<td class="content">
    <?php /*?>Content Here ......<?php */?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <?php if(isset($_GET) && isset($_GET['msg']) && ($_GET["msg"]=="ACCDENIED")){ ?>
                 <td align="center" class="error"><?php echo "You don't have privileges to do this action."; ?></td>
            <?php } ?>
        </table>
        <div class="home-icon">
            <ul>
            <?php //print_r($_SESSION); ?>
            <?php
			$content123 = '';
			while($row_role = mysql_fetch_assoc($sel_adminRole)) {
				if($_SESSION['admin_role'] < $row_role['role'] OR $_SESSION['admin_role']==0){
				$content123 .= '<li>
					<div>
						<a href="'.SITE_ADM.$row_role['pagenm'].'" title="'.$row_role['title'].'">
						<img src="'.SITE_ADM_IMG.$row_role['image'].'" alt="'.$row_role['title'].'" />
						</a>
					</div>
					<div>
						<a href="'.SITE_ADM.$row_role['pagenm'].'" title="'.$row_role['title'].'">'.$row_role['title'].'</a>
					</div>
					</li>';
				}
			}
			echo $content123;	
			?>
            </ul>
        </div> 
    </td>
	<td width="10" align="right" class="content-right-bg"></td>
  </tr>
  <tr>
	<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>content-main-box-bottom-left.gif" alt="img" /></td>
	<td class="content-bottom-bg"></td>
	<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>content-main-box-bottom-right.gif" alt="img" /></td>
  </tr>
</table>