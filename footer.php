<?php
$con = mysqli_connect("localhost", "root", "", "online_survey_system");
?>

<div class="section-footer background-colour-grey padding-huge">
  <div class="container-medium">
    <div class="top_footer-block">
      <div class="footer_col-1">
        <a href="index.php" aria-current="page" class="footer-logo w-inline-block w--current">
          <img src="assets/user/main_web/image/logo.png" loading="lazy" width="100%" height="100%"
            alt="SurveyEase logo">
        </a>
        <div>
          <div class="text-size-small text-colour-blue">SurveyEase is a digital survey solution that helps anyone
            create surveys, build questionnaires and analyse the results.</div>
        </div>
        <div class="footer_col" style="margin-top: 15px;">
          <div class="footer-title">
            <h5 class="text-weight-semibold text-colour-black">NAVIGATION</h5>
          </div>
          <div class="footer-links-block_body">
            <a href="index.php" aria-current="page" class="text-size-small is-footer-link w--current">Home</a>
            <a href="all_template.php" class="text-size-small is-footer-link">Templates</a>
            <a href="aboutus.php" class="text-size-small is-footer-link">About Us</a>
            <a href="blog.php" class="text-size-small is-footer-link">Blog</a>
            <a href="contact.php" target="_blank" class="text-size-small is-footer-link">Contact us</a>
            <a data-uk-only="true" href="FAQs.php" target="_blank" class="text-size-small is-footer-link">FAQs</a>
          </div>
        </div>
      </div>
      <div class="footer-col_right">
        <div class="footer-links-multi">
          <div class="footer_col">
            <div class="footer-title">
              <a href="customer.php" class="text-colour-black text-weight-semibold text-size-small">Customer
                template</a>
            </div>
            <div id="w-node-f21b8b2f-9882-10ee-7ce6-8ef26ed28b34-b019ffc1" class="footer-links-block_body w-dyn-list">
              <div role="list" class="w-dyn-items">
                <?php
                $sql_category = "SELECT * FROM survey_category WHERE Category='Customer'";
                $res_category = mysqli_query($con, $sql_category);
                $row_cat = mysqli_fetch_assoc($res_category);
                $sql_template = "SELECT * FROM survey_templates WHERE Template_category=" . $row_cat['ID'] . " Limit 5";
                $res_template = mysqli_query($con, $sql_template);
                while ($row = mysqli_fetch_assoc($res_template)) {
                  ?>
                  <div role="listitem" class="w-dyn-item">
                    <a href="template.php?template_id=<?php echo $row['ID']; ?>"
                      class="text-size-small is-footer-link is-footer-blog-link"><?php echo $row['Template_name']; ?></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="footer_col">
            <div class="footer-title">
              <a href="healthcare.php" class="text-colour-black text-weight-semibold text-size-small">Healthcare
                template</a>
            </div>
            <div id="w-node-f21b8b2f-9882-10ee-7ce6-8ef26ed28b34-b019ffc1" class="footer-links-block_body w-dyn-list">
              <div role="list" class="w-dyn-items">
                <?php
                $sql_category = "SELECT * FROM survey_category WHERE Category='Healthcare'";
                $res_category = mysqli_query($con, $sql_category);
                $row_cat = mysqli_fetch_assoc($res_category);
                $sql_template = "SELECT * FROM survey_templates WHERE Template_category=" . $row_cat['ID'] . " Limit 5";
                $res_template = mysqli_query($con, $sql_template);
                while ($row = mysqli_fetch_assoc($res_template)) {
                  ?>
                  <div role="listitem" class="w-dyn-item">
                    <a href="template.php?template_id=<?php echo $row['ID']; ?>"
                      class="text-size-small is-footer-link is-footer-blog-link"><?php echo $row['Template_name']; ?></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-links-multi">
          <div class="footer_col">
            <div class="footer-title">
              <a href="education.php" class="text-colour-black text-weight-semibold text-size-small">Education
                template</a>
            </div>
            <div id="w-node-f21b8b2f-9882-10ee-7ce6-8ef26ed28b34-b019ffc1" class="footer-links-block_body w-dyn-list">
              <div role="list" class="w-dyn-items">
                <?php
                $sql_category = "SELECT * FROM survey_category WHERE Category='Education'";
                $res_category = mysqli_query($con, $sql_category);
                $row_cat = mysqli_fetch_assoc($res_category);
                $sql_template = "SELECT * FROM survey_templates WHERE Template_category=" . $row_cat['ID'] . " Limit 5";
                $res_template = mysqli_query($con, $sql_template);
                while ($row = mysqli_fetch_assoc($res_template)) {
                  ?>
                  <div role="listitem" class="w-dyn-item">
                    <a href="template.php?template_id=<?php echo $row['ID']; ?>"
                      class="text-size-small is-footer-link is-footer-blog-link"><?php echo $row['Template_name']; ?></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="footer_col">
            <div class="footer-title">
              <a href="hospitality.php" class="text-colour-black text-weight-semibold text-size-small">Hospitality
                template</a>
            </div>
            <div id="w-node-f21b8b2f-9882-10ee-7ce6-8ef26ed28b34-b019ffc1" class="footer-links-block_body w-dyn-list">
              <div role="list" class="w-dyn-items">
                <?php
                $sql_category = "SELECT * FROM survey_category WHERE Category='Hospitality'";
                $res_category = mysqli_query($con, $sql_category);
                $row_cat = mysqli_fetch_assoc($res_category);
                $sql_template = "SELECT * FROM survey_templates WHERE Template_category=" . $row_cat['ID'] . " Limit 5";
                $res_template = mysqli_query($con, $sql_template);
                while ($row = mysqli_fetch_assoc($res_template)) {
                  ?>
                  <div role="listitem" class="w-dyn-item">
                    <a href="template.php?template_id=<?php echo $row['ID']; ?>"
                      class="text-size-small is-footer-link is-footer-blog-link"><?php echo $row['Template_name']; ?></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-links-multi">
          <div class="footer_col">
            <div class="footer-title">
              <a href="employee.php" class="text-colour-black text-weight-semibold text-size-small">Employee
                template</a>
            </div>
            <div id="w-node-f21b8b2f-9882-10ee-7ce6-8ef26ed28b34-b019ffc1" class="footer-links-block_body w-dyn-list">
              <div role="list" class="w-dyn-items">
                <?php
                $sql_category = "SELECT * FROM survey_category WHERE Category='Employee'";
                $res_category = mysqli_query($con, $sql_category);
                $row_cat = mysqli_fetch_assoc($res_category);
                $sql_template = "SELECT * FROM survey_templates WHERE Template_category=" . $row_cat['ID'] . " Limit 5";
                $res_template = mysqli_query($con, $sql_template);
                while ($row = mysqli_fetch_assoc($res_template)) {
                  ?>
                  <div role="listitem" class="w-dyn-item">
                    <a href="template.php?template_id=<?php echo $row['ID']; ?>"
                      class="text-size-small is-footer-link is-footer-blog-link"><?php echo $row['Template_name']; ?></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="footer_col">
            <div class="footer-title">
              <a href="marketresearch.php" class="text-colour-black text-weight-semibold text-size-small">Market
                Research
                template</a>
            </div>
            <div id="w-node-f21b8b2f-9882-10ee-7ce6-8ef26ed28b34-b019ffc1" class="footer-links-block_body w-dyn-list">
              <div role="list" class="w-dyn-items">
                <?php
                $sql_category = "SELECT * FROM survey_category WHERE Category='Market Research'";
                $res_category = mysqli_query($con, $sql_category);
                $row_cat = mysqli_fetch_assoc($res_category);
                $sql_template = "SELECT * FROM survey_templates WHERE Template_category=" . $row_cat['ID'] . " Limit 5";
                $res_template = mysqli_query($con, $sql_template);
                while ($row = mysqli_fetch_assoc($res_template)) {
                  ?>
                  <div role="listitem" class="w-dyn-item">
                    <a href="template.php?template_id=<?php echo $row['ID']; ?>"
                      class="text-size-small is-footer-link is-footer-blog-link"><?php echo $row['Template_name']; ?></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-links-multi">
          <div class="footer_col">
            <div class="footer-title">
              <a href="events.php" class="text-colour-black text-weight-semibold text-size-small">Events
                template</a>
            </div>
            <div id="w-node-f21b8b2f-9882-10ee-7ce6-8ef26ed28b34-b019ffc1" class="footer-links-block_body w-dyn-list">
              <div role="list" class="w-dyn-items">
                <?php
                $sql_category = "SELECT * FROM survey_category WHERE Category='Events'";
                $res_category = mysqli_query($con, $sql_category);
                $row_cat = mysqli_fetch_assoc($res_category);
                $sql_template = "SELECT * FROM survey_templates WHERE Template_category=" . $row_cat['ID'] . " Limit 5";
                $res_template = mysqli_query($con, $sql_template);
                while ($row = mysqli_fetch_assoc($res_template)) {
                  ?>
                  <div role="listitem" class="w-dyn-item">
                    <a href="template.php?template_id=<?php echo $row['ID']; ?>"
                      class="text-size-small is-footer-link is-footer-blog-link"><?php echo $row['Template_name']; ?></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="footer_col">
            <div class="footer-title">
              <a href="training.php" class="text-colour-black text-weight-semibold text-size-small">Training
                template</a>
            </div>
            <div id="w-node-f21b8b2f-9882-10ee-7ce6-8ef26ed28b34-b019ffc1" class="footer-links-block_body w-dyn-list">
              <div role="list" class="w-dyn-items">
                <?php
                $sql_category = "SELECT * FROM survey_category WHERE Category='Training '";
                $res_category = mysqli_query($con, $sql_category);
                $row_cat = mysqli_fetch_assoc($res_category);
                $sql_template = "SELECT * FROM survey_templates WHERE Template_category=" . $row_cat['ID'] . " Limit 5";
                $res_template = mysqli_query($con, $sql_template);
                while ($row = mysqli_fetch_assoc($res_template)) {
                  ?>
                  <div role="listitem" class="w-dyn-item">
                    <a href="template.php?template_id=<?php echo $row['ID']; ?>"
                      class="text-size-small is-footer-link is-footer-blog-link"><?php echo $row['Template_name']; ?></a>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="lower_footer-block">
      <div class="text-size-small text-colour-blue">Copyright © 2024 SurveyEase™. All Rights Reserved.</div>
    </div>
  </div>
</div>
</main>
</div>

</body>

</html>