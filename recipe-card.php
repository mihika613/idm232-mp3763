<!-- 
<?php 
print_r($recipe);
print_r($recipe['id']);
?> -->



<?php if (!empty($recipe) && isset($recipe['id'])): ?>
    <!-- ONLY print the card if recipe has the needed data -->
    <a href="recipe.php?id=<?php echo urlencode($recipe['id']); ?>" class="recipecardwrapper">
      <div class="recipe-card">
        <img
          alt="<?php echo htmlspecialchars($recipe['title'] ?? ''); ?>"
          src="<?php echo 'new_images/' . ($recipe['id'] ?? '') . '/' . htmlspecialchars($recipe['main_img'] ?? ''); ?>"
        >
        <h6><?php echo htmlspecialchars($recipe['protein'] ?? ''); ?></h6>
        <h3><?php echo htmlspecialchars($recipe['title'] ?? ''); ?></h3>
        <h4><?php echo htmlspecialchars($recipe['subtitle'] ?? ''); ?></h4>
        <div class="in-line">
          <h6>⏱ <?php echo htmlspecialchars($recipe['cook_time'] ?? ''); ?></h6>
          <h6><?php echo htmlspecialchars($recipe['calories'] ?? ''); ?> cal</h6>
        </div>
      </div>
    </a>
<?php endif; ?>