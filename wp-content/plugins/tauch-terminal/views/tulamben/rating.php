<div>
    <div class="row">
        <div class="col-sm-8">
            <?php //var_dump($data_review->business) ?>
            <div class="list-unstyled ratings">
            <?php foreach ($data_review->reviews->review as $review): ?>
                <div class="rating">
                    <h3>
                        <span class="badge badge-review<?php if($review->overallRating >=5): ?> badge-super<?php elseif($review->overallRating >=4): ?> badge-good<?php elseif($review->overallRating >=3): ?> badge-neutral<?php else: ?> badge-bad<?php endif; ?>"><?php echo number_format((float)$review->overallRating, 2, '.', '') ?></span>
                        <?php if (!empty((array) $review->author)): ?><?php printf('From: %s', $review->author) ?><?php else: ?><?php echo __('From: Anonymous') ?><?php endif; ?>
                        <span class="pull-right"><?php echo mysql2date('j M Y', $review->date) ?></span>
                    </h3>
                    <p><?php echo $review->overallComment ?></p>
                    <div class="panel-group" role="tablist">
                        <div class="panel panel-nostyle">
                            <div class="panel-heading" role="tab" id="id-heading-<?php echo $review->id ?>">
                                <h4 class="panel-title">
                                    <a class="" role="button" data-toggle="collapse" href="#id-group-<?php echo $review->id ?>" aria-expanded="true" aria-controls="id-group-<?php echo $review->id ?>">
                                        <?php echo __('Rating Details') ?>
                                        <span class="glyphicon glyphicon-menu-down pull-right"></span>
                                    </a>
                                </h4>
                            </div>
                            <div id="id-group-<?php echo $review->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="id-heading-<?php echo $review->id ?>" aria-expanded="true">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="list-group">
                                            <?php $index = 0 ?>
                                            <?php foreach ($review->subcategoryRatings->subcategoryRating as $rating): ?>
                                                <div class="list-group-item">
                                                    <h5 class="list-group-item-heading pull-left"><?php echo $rating->category ?></h5>
                                                    <p class="list-group-item-text pull-right"><span class="slider"><span class="<?php if($rating->rating >=5): ?> slider-100<?php elseif($rating->rating >=4): ?> slider-75<?php elseif($rating->rating >=3): ?> slider-50<?php elseif($rating->rating >=2): ?> slider-25<?php else: ?> slider-0<?php endif; ?>"><span><?php echo $rating->rating ?></span></span></span></p>
                                                </div>
                                <?php if (ceil(count($review->subcategoryRatings->subcategoryRating) / 2) == ++$index): ?>
                                    </div></div><div class="col-sm-6"><div class="list-group">
                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="jumbotron">
                <h3><?php echo __('average Rating') ?></h3>
                <h2><?php echo $globalStatistics->averageRating ?></h2>
                <p><?php printf('out of %s reviews and %s different protals', $globalStatistics->reviewCount, $globalStatistics->portalCount) ?></p>
            </div>
        </div>
    </div>
</div>
