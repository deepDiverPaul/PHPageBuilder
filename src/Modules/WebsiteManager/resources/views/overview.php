<?php
$pagesTabActive = ! isset($_GET['tab']) || $_GET['tab'] === 'pages' ? 'active' : '';
$menusTabActive = isset($_GET['tab']) && $_GET['tab'] === 'menus' ? 'active' : '';
$settingsTabActive = isset($_GET['tab']) && $_GET['tab'] === 'settings' ? 'active' : '';
$filesTabActive = isset($_GET['tab']) && $_GET['tab'] === 'files' ? 'active' : '';
?>
<div class="py-5 text-center">
    <h2><?= phpb_trans('website-manager.title') ?></h2>
</div>

<div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?= phpb_e($pagesTabActive) ?>" href="?tab=pages"><?= phpb_trans('website-manager.pages') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= phpb_e($menusTabActive) ?>" href="?tab=menus"><?= phpb_trans('website-manager.menus') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= phpb_e($filesTabActive) ?>" href="?tab=files"><?= phpb_trans('website-manager.files') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= phpb_e($settingsTabActive) ?>" href="?tab=settings"><?= phpb_trans('website-manager.settings') ?></a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="pages" class="tab-pane <?= phpb_e($pagesTabActive) ?>">

                <h4><?= phpb_trans('website-manager.pages') ?></h4>

                <div class="main-spacing">
                    <?php
                    if (phpb_flash('message')):
                    ?>
                    <div class="alert alert-<?= phpb_flash('message-type') ?>">
                        <?= phpb_flash('message') ?>
                    </div>
                    <?php
                    endif;
                    ?>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><?= phpb_trans('website-manager.name') ?></th>
                                <th scope="col"><?= phpb_trans('website-manager.route') ?></th>
                                <th scope="col"><?= phpb_trans('website-manager.actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($pages as $page):
                                ?>
                                <tr>
                                    <td>
                                        <?= phpb_e($page->getName()) ?>
                                    </td>
                                    <td>
                                        <?= phpb_e($page->getRoute()) ?>
                                    </td>
                                    <td class="actions">
                                        <a href="<?= phpb_e(phpb_full_url($page->getRoute())) ?>" target="_blank" class="btn btn-light btn-sm">
                                            <span><?= phpb_trans('website-manager.view') ?></span> <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= phpb_url('pagebuilder', ['page' => $page->getId()]) ?>" class="btn btn-primary btn-sm">
                                            <span><?= phpb_trans('website-manager.edit') ?></span> <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= phpb_url('website_manager', ['route' => 'page_settings', 'action' => 'edit', 'page' => $page->getId()]) ?>" class="btn btn-secondary btn-sm">
                                            <span><?= phpb_trans('website-manager.settings') ?></span> <i class="fas fa-cog"></i>
                                        </a>
                                        <a href="<?= phpb_url('website_manager', ['route' => 'page_settings', 'action' => 'destroy', 'page' => $page->getId()]) ?>" class="btn btn-danger btn-sm">
                                            <span><?= phpb_trans('website-manager.remove') ?></span> <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="mb-3">
                <a href="<?= phpb_url('website_manager', ['route' => 'page_settings', 'action' => 'create']) ?>" class="btn btn-primary btn-sm">
                    <?= phpb_trans('website-manager.add-new-page') ?>
                </a>

            </div>
            <div id="menus" class="tab-pane <?= phpb_e($menusTabActive) ?>">

                <h4 class="mb-3"><?= phpb_trans('website-manager.menus') ?></h4>

            </div>
            <div id="files" class="tab-pane <?= phpb_e($filesTabActive) ?>">

                <h4 class="mb-3"><?= phpb_trans('website-manager.files') ?></h4>

                <div class="row mb-4">
                    <div class="col">
                        <div class="custom-file">
                            <input id="fileupload" type="file" name="fileupload" class="custom-file-input" onchange="uploadFile()" onselect="uploadFile()">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>




                <div class="d-flex flex-wrap " style="gap:1rem;">
                <?php
                foreach ($files as $file) :
                ?>
                        <div class="position-relative">
                            <img src="<?= phpb_e($file->getUrl()) ?>" alt="<?= phpb_e($file->public_id) ?>" class="img-thumbnail" style="max-height: 10rem;">
                            <div class="position-absolute" style="top:2px;right:2px;">
                                <button onclick="deleteFile('<?= phpb_e($file->public_id) ?>')" class="btn btn-danger btn-sm mb-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                <?php
                endforeach;
                ?>
                </div>

                <script>
                  async function uploadFile() {
                    let formData = new FormData();
                    formData.append("files", fileupload.files[0]);
                    await fetch('<?= phpb_url('pagebuilder', ['action' => 'upload', 'page' => '1']) ?>', {
                      method: "POST",
                      body: formData
                    }).then(() => {
                      location.reload();
                    }).catch(() => {alert('An Error occured.')});
                  }
                  async function deleteFile(id) {
                    let formData = new FormData();
                    formData.append("id", id);
                    await fetch('<?= phpb_url('pagebuilder', ['action' => 'upload_delete', 'page' => '1']) ?>', {
                      method: "POST",
                      body: formData
                    }).then(() => {
                      location.reload();
                    }).catch(() => {alert('An Error occured.')});
                  }
                </script>

            </div>
            <div id="settings" class="tab-pane <?= phpb_e($settingsTabActive) ?>">

                <h4 class="mb-3"><?= phpb_trans('website-manager.settings') ?></h4>

                <?php
                require __DIR__ . '/settings.php';
                ?>

            </div>
        </div>
    </div>
</div>

<script>
  document.querySelectorAll('a[data-toggle="tab"]').forEach(el => {
  el.addEventListener('shown.bs.tab', function (e) {
      console.log(e.target) // newly activated tab
    })
  })

</script>
