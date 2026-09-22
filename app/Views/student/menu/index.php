<?= $this->extend('student/layouts/main') ?>
<?= $this->section('content') ?>
<?php if (!empty($todayMenu)): ?>
<div class="card stat-card mb-4">
    <div class="card-header bg-white py-3"><h5 class="mb-0"><i class="bi bi-calendar-check me-2 text-success"></i>Today's Menu — <?= date('d M Y (l)', strtotime($todayMenu['menu_date'])) ?></h5></div>
    <div class="card-body">
        <?php $g = []; foreach ($todayMenu['items'] as $i) $g[$i['meal_type']][] = $i; ?>
        <div class="row">
            <?php foreach (['breakfast','lunch','evening','dinner'] as $mt): ?>
            <?php if (!empty($g[$mt])): ?>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="p-3 rounded h-100 <?php if($mt==='lunch'):?>bg-success<?php elseif($mt==='evening'):?>bg-info<?php elseif($mt==='dinner'):?>bg-dark<?php else:?>bg-warning<?php endif;?> bg-opacity-10">
                    <h6 class="mb-2 <?php if($mt==='lunch'):?>text-success<?php elseif($mt==='evening'):?>text-info<?php elseif($mt==='dinner'):?>text-dark<?php else:?>text-warning<?php endif;?>">
                        <i class="bi <?php if($mt==='breakfast'):?>bi-sunrise<?php elseif($mt==='lunch'):?>bi-sun<?php elseif($mt==='evening'):?>bi-cloud-sun<?php else:?>bi-moon-stars<?php endif;?> me-1"></i>
                        <?= ucfirst($mt) ?>
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($g[$mt] as $item): ?>
                        <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-1" style="font-size:10px;"><?= esc($item['food_name']) ?>
                            <?php if (!empty($item['description'])):?><br><small class="text-muted ms-3"><?= esc($item['description']) ?></small><?php endif;?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; endforeach; ?>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card stat-card mb-4"><div class="card-body text-center py-5"><i class="bi bi-calendar-x text-muted" style="font-size:3rem;"></i><h5 class="mt-3 text-muted">No menu set for today</h5></div></div>
<?php endif; ?>
<h5 class="mb-3"><i class="bi bi-calendar-week me-2 text-primary"></i>Weekly Menu</h5>
<?php if (!empty($weeklyMenu)): foreach ($weeklyMenu as $menu): ?>
<div class="card stat-card mb-4">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-8"><h5 class="mb-0"><i class="bi bi-calendar-day me-2 text-primary"></i><?= date('d M Y (l)', strtotime($menu['menu_date'])) ?></h5></div>
            <div class="col-md-4 text-md-end">
                <?php if(date('Y-m-d',strtotime($menu['menu_date']))===date('Y-m-d')):?><span class="badge bg-success">Today</span>
                <?php elseif(date('Y-m-d',strtotime($menu['menu_date']))<date('Y-m-d')):?><span class="badge bg-secondary">Past</span>
                <?php else:?><span class="badge bg-primary">Upcoming</span><?php endif;?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($menu['items'])): $g2 = []; foreach ($menu['items'] as $i) $g2[$i['meal_type']][] = $i; ?>
        <div class="row">
            <?php foreach (['breakfast','lunch','evening','dinner'] as $mt): if (empty($g2[$mt])) continue; ?>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="p-3 rounded h-100 <?php if($mt==='lunch'):?>bg-success<?php elseif($mt==='evening'):?>bg-info<?php elseif($mt==='dinner'):?>bg-dark<?php else:?>bg-warning<?php endif;?> bg-opacity-10">
                    <h6 class="mb-2 <?php if($mt==='lunch'):?>text-success<?php elseif($mt==='evening'):?>text-info<?php elseif($mt==='dinner'):?>text-dark<?php else:?>text-warning<?php endif;?>">
                        <i class="bi <?php if($mt==='breakfast'):?>bi-sunrise<?php elseif($mt==='lunch'):?>bi-sun<?php elseif($mt==='evening'):?>bi-cloud-sun<?php else:?>bi-moon-stars<?php endif;?> me-1"></i><?= ucfirst($mt) ?>
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($g2[$mt] as $item): ?>
                        <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-1" style="font-size:10px;"></i><?= esc($item['food_name']) ?>
                            <?php if (!empty($item['description'])):?><br><small class="text-muted ms-3"><?= esc($item['description']) ?></small><?php endif;?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-muted text-center mb-0">No items for this day.</p>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; else: ?>
<div class="card stat-card"><div class="card-body text-center py-5"><i class="bi bi-utensils text-muted" style="font-size:3rem;"></i><h5 class="mt-3 text-muted">No weekly menu available</h5></div></div>
<?php endif; ?>
<style>.text-purple{color:#6f42c1!important;}.bg-purple{background-color:#c6b5e3!important;}</style>
<?= $this->endSection() ?>