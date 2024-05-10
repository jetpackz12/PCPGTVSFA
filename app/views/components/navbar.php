<nav class="navbar navbar-expand text-white">
    <div class="container-fluid">
        <div class="d-flex align-items-center gap-1">
            <img class="img-thumbnail" src="<?php echo BOOTSTRAP; ?>/images/clearance-logo.png" alt="My Logo" style="width: 30px; height: 30px;">
            <h3 class="d-inline">
                <?php
                $object = new settingModel();
                $result = $object->get_system_name();
                echo $result;
                ?>
            </h3>
        </div>
        <div class="d-flex align-content-center gap-2">
            <button class="d-block d-md-none btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <i class="fa fa-bars"></i>
            </button>
            <a class="d-none d-md-block text-white text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" style="font-size: 1.4rem;">
                <i class="fa fa-door-open"></i>
                logout
            </a>
        </div>
    </div>
</nav>
<div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="height: 100vh;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">
            <?php
            $object = new settingModel();
            $result = $object->get_system_name();
            echo $result;
            ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php $arr_multi_role = explode(",", $_SESSION['multi_role']['permission']); ?>
        <div class="list-group rounded-0 gap-3 p-2">
            <?php if (in_array("Dashboard", $arr_multi_role)) { ?>
                <a class="text-black text-decoration-none rounded-2 d-flex align-items-center gap-1 list-group-item list-group-item-action home" href="<?php echo ROOT; ?>home" style="height: 60px;">
                    <i class="fa fa-home"></i>
                    Dashboard
                </a>
            <?php } ?>
            <?php if (in_array("Manage Student", $arr_multi_role)) { ?>
                <a class="text-black text-decoration-none rounded-2 d-flex align-items-center gap-1 list-group-item list-group-item-action manage_student" href="<?php echo ROOT; ?>manage_student" style="height: 60px;">
                    <i class="fa fa-graduation-cap"></i>
                    Manage Student
                </a>
            <?php } ?>
            <?php if (in_array("Manage Advisory And Teacher", $arr_multi_role)) { ?>
                <div class="accordion mb-2" id="accordionManageAdvisoryTeacher">
                    <div class="accordion-item">
                        <h2 class="accordion-header" style="height: 60px;">
                            <button class="accordion-button gap-1 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdvisoryTeacher" aria-expanded="false" aria-controls="collapseAdvisoryTeacher">
                                <i class="fa fa-chalkboard-user"></i>
                                Manage Advisory And Teacher
                            </button>
                        </h2>
                        <div id="collapseAdvisoryTeacher" class="accordion-collapse collapse" data-bs-parent="#accordionManageAdvisoryTeacher">
                            <div class="accordion-body d-flex flex-column gap-2 pt-4">
                                <?php if (in_array("Advisory", $arr_multi_role)) { ?>
                                    <a class="text-black text-decoration-none rounded-2 border border-black d-flex align-items-center justify-content-center list-group-item list-group-item-action manage_advisory" href="<?php echo ROOT; ?>manage_advisory" style="height: 60px;">
                                        Advisory
                                    </a>
                                <?php } ?>
                                <?php if (in_array("Teacher", $arr_multi_role)) { ?>
                                    <a class="text-black text-decoration-none rounded-2 border border-black d-flex align-items-center justify-content-center list-group-item list-group-item-action manage_teacher" href="<?php echo ROOT; ?>manage_teacher" style="height: 60px;">
                                        Teacher
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array("Manage Faculty", $arr_multi_role)) { ?>
                <div class="accordion" id="accordionManageFaculty">
                    <div class="accordion-item">
                        <h2 class="accordion-header" style="height: 60px;">
                            <button class="accordion-button gap-1 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaculty" aria-expanded="false" aria-controls="collapseFaculty">
                                <i class="fa fa-school"></i>
                                Manage Faculty
                            </button>
                        </h2>
                        <div id="collapseFaculty" class="accordion-collapse collapse" data-bs-parent="#accordionManageFaculty">
                            <div class="accordion-body d-flex flex-column gap-2 pt-2">
                                <?php if (in_array("Assign Subjects", $arr_multi_role)) { ?>
                                    <a class="text-black text-decoration-none rounded-2 border border-black d-flex align-items-center justify-content-center list-group-item list-group-item-action manage_faculty" href="<?php echo ROOT; ?>manage_faculty" style="height: 60px;">
                                        Assign Subjects
                                    </a>
                                <?php } ?>
                                <?php if (in_array("Subject Assignee", $arr_multi_role)) { ?>
                                    <a class="text-black text-decoration-none rounded-2 border border-black d-flex align-items-center justify-content-center list-group-item list-group-item-action manage_assignee" href="<?php echo ROOT; ?>manage_assignee" style="height: 60px;">
                                        Subject Assignee
                                    </a>
                                <?php } ?>
                                <?php if (in_array("School Treasurer", $arr_multi_role)) { ?>
                                    <a class="text-black text-decoration-none rounded-2 border border-black d-flex align-items-center justify-content-center list-group-item list-group-item-action manage_faculty_cashier" href="<?php echo ROOT; ?>manage_faculty_cashier" style="height: 60px;">
                                        School Treasurer
                                    </a>
                                <?php } ?>
                                <?php if(in_array("Other Signatory", $arr_multi_role)) { ?>
                                    <a class="text-black text-decoration-none rounded-2 border border-black d-flex align-items-center justify-content-center list-group-item list-group-item-action manage_faculty_signatory" href="<?php echo ROOT;?>manage_faculty_signatory" style="height: 60px;">
                                        Register Other Signatory
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array("Grade Section And Subjects", $arr_multi_role)) { ?>
                <div class="accordion mb-2" id="accordionManageGradeSectionSubjects">
                    <div class="accordion-item">
                        <h2 class="accordion-header" style="height: 60px;">
                            <button class="accordion-button gap-1 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGradeSectionSubjects" aria-expanded="false" aria-controls="collapseGradeSectionSubjects">
                                <i class="fa fa-section"></i>
                                Grade, Section And Subjects
                            </button>
                        </h2>
                        <div id="collapseGradeSectionSubjects" class="accordion-collapse collapse" data-bs-parent="#accordionManageGradeSectionSubjects">
                            <div class="accordion-body d-flex flex-column gap-2 pt-4">
                                <?php if (in_array("Grade", $arr_multi_role)) { ?>
                                    <a class="text-black text-decoration-none rounded-2 border border-black d-flex align-items-center justify-content-center list-group-item list-group-item-action manage_grade" href="<?php echo ROOT; ?>manage_grade" style="height: 60px;">
                                        Grade
                                    </a>
                                <?php } ?>
                                <?php if (in_array("Section", $arr_multi_role)) { ?>
                                    <a class="text-black text-decoration-none rounded-2 border border-black d-flex align-items-center justify-content-center list-group-item list-group-item-action manage_section" href="<?php echo ROOT; ?>manage_section" style="height: 60px;">
                                        Section
                                    </a>
                                <?php } ?>
                                <?php if (in_array("Subjects", $arr_multi_role)) { ?>
                                    <a class="text-black text-decoration-none rounded-2 border border-black d-flex align-items-center justify-content-center list-group-item list-group-item-action manage_subject" href="<?php echo ROOT; ?>manage_subject" style="height: 60px;">
                                        Subjects
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (in_array("Manage User Account", $arr_multi_role)) { ?>
                <a class="text-black text-decoration-none rounded-2 d-flex align-items-center gap-1 list-group-item list-group-item-action manage_user_account" href="<?php echo ROOT; ?>manage_user_account" style="height: 60px;">
                    <i class="fa fa-users-gear"></i>
                    Manage User Account
                </a>
            <?php } ?>
            <?php if (in_array("Fees Management", $arr_multi_role)) { ?>
                <a class="text-black text-decoration-none rounded-2 d-flex align-items-center gap-1 list-group-item list-group-item-action fees_management" href="<?php echo ROOT; ?>fees_management" style="height: 60px;">
                    <i class="fa fa-money-bill"></i>
                    Fees Management
                </a>
            <?php } ?>
            <?php if (in_array("Role and Permission", $arr_multi_role)) { ?>
                <a class="text-black text-decoration-none rounded-2 d-flex align-items-center gap-1 list-group-item list-group-item-action role_and_permission" href="<?php echo ROOT; ?>role_and_permission" style="height: 60px;">
                    <i class="fa fa-user-pen"></i>
                    Role and Permission
                </a>
            <?php } ?>
            <?php if (in_array("System Settings", $arr_multi_role)) { ?>
                <a class="text-black text-decoration-none rounded-2 d-flex align-items-center gap-1 list-group-item list-group-item-action system_settings" href="<?php echo ROOT; ?>system_settings" style="height: 60px;">
                    <i class="fa fa-gear"></i>
                    System Settings
                </a>
            <?php } ?>
            <a class="text-black text-decoration-none rounded-2 d-flex align-items-center gap-1 list-group-item list-group-item-action" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fa fa-door-open"></i>
                logout
            </a>
        </div>
    </div>
</div>