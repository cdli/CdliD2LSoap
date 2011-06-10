<h1>Welcome, <?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?></h1>
<dl>
    <dt style="width:200px;float: left;">ID:</dt>
    <dd><?php echo $user->getUserID(); ?></dd>
    <dt style="width:200px;float: left;">Username:</dt>
    <dd><?php echo $user->getUserName(); ?></dd>
    <dt style="width:200px;float: left;">Email Address:</dt>
    <dd><?php echo $user->getEmailAddress(); ?></dd>
</dl>

<h2>Your Course Enrollments</h2>
<?php if ( count($enrollments) > 0 ): ?>
<ul>
<?php foreach ( $enrollments as $enr ): ?>
    <li><strong><?php echo $enr['CourseOffering']->getName(); ?></strong> as <?php echo $enr['Role']->getRoleName(); ?></li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p>You are not enrolled in any courses!</p>
<?php endif; ?>