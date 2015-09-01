<div>
    <h2><?php echo __('Reviews', 'tauch-terminal') ?></h2>
    <div class="row">
        <div class="col-sm-8 col-md-7">
            <div class="ratings">
            <?php foreach ($data_review as $review): ?>
                <?php $percent = (float)$review->overallRating; ?>
                <?php $percent = (float)($percent / 5 * 100); ?>
                <div class="rating clearfix">
                    <div class="col-sm-4 col-md-3">
                        <div class="c100 p<?php echo floor($percent) ?><?php if(($percent) > 70): ?> green<?php elseif(($percent) > 40): ?> orange<?php else: ?> red<?php endif ?>">
                            <span><?php echo number_format((float)$percent, 1, '.', '') ?>%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-9">
                        <h3>
                            <?php if ($review->author != ''): ?><?php printf('From: %s', $review->author) ?><?php else: ?><?php echo __('From: Anonymous') ?><?php endif; ?>
                            <span class="pull-right"><?php echo mysql2date('j M Y', $review->date) ?></span>
                        </h3>
                        <p><?php echo $review->overallComment ?></p>
                    </div>
                    <div class="col-sm-12 col-md-9 col-md-offset-3">
                        <div class="panel-group" role="tablist">
                            <div class="panel panel-nostyle">
                                <div class="panel-heading" role="tab" id="id-heading-<?php echo $review->id ?>">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" href="#id-group-<?php echo $review->id ?>" aria-expanded="true" aria-controls="id-group-<?php echo $review->id ?>">
                                            <?php echo __('Rating Details') ?>
                                            <span class="glyphicon glyphicon-menu-up pull-right"></span>
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
                </div>
            <?php endforeach; ?>
            </div>
            <nav class="text-center">
                <ul class="pagination">
                    <?php $prev = (($pagination->getPage() - 1) > 1) ? ($pagination->getPage() - 1) : '#'?>
                    <li<?php if ($pagination->getPage() == 1): ?> class="disabled"<?php endif ?>>
                        <a href="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']  ?>?page=<?php echo $prev ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php for($i = 1; $i <= $pagination->getTotalPages(); $i++): ?>
                    <li<?php if ($pagination->getPage() == $i): ?> class="active"<?php endif ?>>
                        <a href="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']  ?>?page=<?php echo $i ?>">
                            <?php echo $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
                    <li<?php if ($pagination->getPage() == $pagination->getTotalPages()): ?> class="disabled"<?php endif ?>>
                        <?php $next = (($pagination->getPage() + 1) <= $pagination->getTotalPages()) ? ($pagination->getPage() + 1) : '#'?>
                        <a href="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']  ?>?page=<?php echo $next ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-sm-4 col-md-4 col-md-offset-1 rating-overview">
            <div class="jumbotron text-center">
                <h3><?php echo __('Average Rating') ?></h3>
                <div class="clearfix">
                    <div class="c100 p<?php echo floor($globalStatistics->averageRatingPercentage) ?><?php if($globalStatistics->averageRatingPercentage > 70): ?> green<?php elseif($globalStatistics->averageRatingPercentage > 40): ?> orange<?php else: ?> red<?php endif ?>">
                        <span><?php echo $globalStatistics->averageRatingPercentage ?>%</span>
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                </div>
                <p><?php printf('out of %s reviews and<br/>%s different protals', $globalStatistics->reviewCount, $globalStatistics->portalCount) ?></p>
            </div>
            <div class="jumbotron text-center">
                <h3><?php echo __('Portal Statistics') ?></h3>
                <table class="table table-hover">
                <?php foreach ($portalStatistics->portal as $portal): ?>
                    <tr>
                        <th><?php echo $portal->name ?></th>
                        <td><?php echo $portal->averageRatingPercentage ?>%</td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
