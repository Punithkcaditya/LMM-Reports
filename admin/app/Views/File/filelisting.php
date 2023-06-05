
<div class="container-fluid pt-8">
						<div class="page-header mt-0 shadow p-3">
							<ol class="breadcrumb mb-sm-0">
								<li class="breadcrumb-item"><a href="#">Tables</a></li>
								<li class="breadcrumb-item active" aria-current="page">Data Tables</li>
							</ol>
							<div class="btn-group mb-0">
					
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="card shadow">
									<div class="card-header">
										<h2 class="mb-0">Data Table</h2>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered w-100 text-nowrap">
												<thead>
													<tr>
														<th class="wd-15p">S No</th>
														<th class="wd-15p">File Name</th>
														<th class="wd-25p">Actions</th>
													</tr>
												</thead>
												<tbody>

													<?php
													if ($fileNames) {
                                                    $i = 0;
														foreach ($fileNames as $key): ?>
														<tr>
															<th><?=++$i?></th>
															<td><?=$key?></td>
															<td>
                                                            <a href="<?= base_url('downloadfile/'.$key) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-download"></i></a>
															</td>
														</tr>
													<?php endforeach;
													} else {?>
														<tr>
															<td class="p-1 text-center" colspan="4">No result found</td>
														</tr>
													<?php }?>
												</tbody>
											</table>
										</div>
									</div>
								</div>

							</div>
						</div>

					</div>
