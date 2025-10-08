<main class="admin__main overview__main">
  <section class="overview_stats__section">
    <h2 class="overview_stats__h2">Welcome Back</h2>
    <p class="overview_stats__p big-text">Here are students updates</p>

    <ul class="none overview_stats__ul">
      <li class="overview_stats__li">
        <ul class="none">
          <li>
            <i class="fa-solid fa-user"></i>
            <span class="nowrap">Total Students</span>
          </li>
          <li>
            <strong><?= AdminModel::totalStudent() ?></strong>
          </li>
          <li>
            <small>Number of students enrolled accross all courses</small>
          </li>
        </ul>
      </li>
      <li class="overview_stats__li">
        <ul class="none">
          <li>
            <i class="fa-solid fa-circle-exclamation" style="color: #ff0000;"></i>
            <span class="nowrap">Grading Alert</span>
          </li>
          <li>
            <span><strong>3</strong> Pending Assignment</span>
          </li>
          <li>
            <button class="btn">View</button>
          </li>
        </ul>
      </li>
      <li class="overview_stats__li">
        <ul class="none">
          <li>
            <i class="fa-solid fa-percent" style="color: #63E6BE;"></i>
            <span class="nowrap">Average completion rate</span>
          </li>
          <li>
            <strong>76%</strong>
          </li>
          <li>
            <small>Your students have completed 76% of the courses</small>
          </li>
        </ul>
      </li>
    </ul>
  </section>  

  <section class="overview_graph_section">
    <h2 class="h2">Acedemic Performance</h2>
    <p class="center">Graph Space</p>  
  </section>

  <ul class="none center deadlines">
    <li class="deadlines__header">
      <h2>
        Upcoming Deadlines
      </h2>
      <i>icon</i>
    </li>

    <li class="deadlines__li">
      <span>Assignment Submission - JSS2</span>
      <small class="nowrap">Due Oct 2, 2025 - 11:59 PM</small>
    </li>

    <li class="deadlines_add__li center">
      <i>icon</i>
      <button>Add More</button>
    </li> 
  </ul>
</main>