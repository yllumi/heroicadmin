<input type="text" class="form-control form-control-sm" name="filter[<?=$config['field']; ?>]" value="<?= $this->input->get("filter[{$config['field']}]", true); ?>" placeholder="filter by <?=$config['label']; ?>">