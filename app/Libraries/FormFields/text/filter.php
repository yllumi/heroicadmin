<input type="text" class="form-control form-control-sm form-filter" id="filter-<?= $config['field']; ?>" name=" filter[<?= $config['field']; ?>]" value="<?= $this->input->get("filter[{$config['field']}]", true); ?>" placeholder="filter by <?= $config['label']; ?>">