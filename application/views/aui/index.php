<?php

/**
 * Developer: Yurii Sychov
 * Site: http://sychov.pp.ua
 * Email: yurii@sychov.pp.ua
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ($this->session->user->id == 1) {
	//$this->output->enable_profiler(TRUE);
}

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Language" content="en">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title><?php echo $title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
		<meta name="description" content="Tables are the backbone of almost all web applications.">
		<meta name="msapplication-tap-highlight" content="no">
		<!--
		=========================================================
		* ArchitectUI HTML Theme Dashboard - v1.0.0
		=========================================================
		* Product Page: https://dashboardpack.com
		* Copyright 2019 DashboardPack (https://dashboardpack.com)
		* Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
		=========================================================
		* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
		-->
		<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
		<link rel="stylesheet" href="/libs/metismenu/dist/metisMenu.min.css">
		<link rel="stylesheet" href="/libs/toastr/build/toastr.min.css">

		<link href="/assets/css/aui.css" rel="stylesheet">

		<link rel="icon" href="data:;base64,=">
	</head>
	<body>
		<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
			<div class="app-header header-shadow">
				<div class="app-header__logo">
					<a href="/">
						<div class="logo-src"></div>
					</a>
					<div class="header__pane ml-auto">
						<div>
							<button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
								<span class="hamburger-box">
									<span class="hamburger-inner"></span>
								</span>
							</button>
						</div>
					</div>
				</div>
				<div class="app-header__mobile-menu">
					<div>
						<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
							<span class="hamburger-box">
								<span class="hamburger-inner"></span>
							</span>
						</button>
					</div>
				</div>
				<div class="app-header__menu">
					<span>
						<button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
							<span class="btn-icon-wrapper">
								<i class="fa fa-ellipsis-v fa-w-6"></i>
							</span>
						</button>
					</span>
				</div>
				<div class="app-header__content">
					<div class="app-header-left">
						<div class="search-wrapper">
							<div class="input-holder">
								<input type="text" class="search-input" placeholder="Type to search">
								<button class="search-icon"><span></span></button>
							</div>
							<button class="close"></button>
						</div>
						<ul class="header-menu nav">
							<li class="nav-item">
								<a href="/" class="nav-link">
									<i class="nav-link-icon fa fa-database"> </i>Статистика
								</a>
							</li>
							<li class="btn-group nav-item">
								<a href="/assets/themes/aui/architectui-html-free" class="nav-link" target="_blank">
									<i class="nav-link-icon fa fa-edit"></i>Шаблон
								</a>
							</li>
							<li class="dropdown nav-item">
								<a href="javascript:void(0);" class="nav-link">
									<i class="nav-link-icon fa fa-cog"></i>Налаштування
								</a>
							</li>
							<?php if ($page === 'main'): ?>
							<li class="btn-group nav-item">
								<a href="javascript:void(0)" class="nav-link" data-toggle="modal" data-target="#mailModal">
									<i class="nav-link-icon fas fa-mail-bulk"></i>Повідомлення
								</a>
							</li>
							<?php endif; ?>
						</ul>
					</div>
					<div class="app-header-right">
						<div class="header-btn-lg pr-0">
							<div class="widget-content p-0">
								<div class="widget-content-wrapper">
									<div class="widget-content-left">
										<div class="btn-group">
											<a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
												<img width="42" class="rounded-circle" src="<?php echo file_exists('./uploads/images/users/'.$this->session->user->id.'.jpg') ? '/uploads/images/users/'.$this->session->user->id.'.jpg' : '/assets/images/avatar.jpg' ?>" alt="">
												<i class="fa fa-angle-down ml-2 opacity-8"></i>
											</a>
											<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
												<button type="button" tabindex="0" class="dropdown-item">Налаштування</button>
												<button type="button" tabindex="0" class="dropdown-item">Права</button>
												<?php if ($page === 'main'): ?>
												<button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#mailModal">Повідомлення</button>
												<?php endif; ?>
												<h6 tabindex="-1" class="dropdown-header">Користувач</h6>
												<a href="/profile" tabindex="0" class="dropdown-item">Профіль</a>
												<div tabindex="-1" class="dropdown-divider"></div>
												<a href="/authentication/logout" tabindex="0" class="dropdown-item">Вихід</a>
											</div>
										</div>
									</div>
									<div class="widget-content-left  ml-3 header-user-info">
										<div class="widget-heading">
											<?php echo $this->session->user->name. ' ' .$this->session->user->surname; ?>
										</div>
										<div class="widget-subheading">
											<?php echo $this->session->user->position; ?>
										</div>
									</div>
									<div class="widget-content-right header-user-info ml-3">
										<button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
											<i class="fa text-white fa-calendar pr-1 pl-1"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ui-theme-settings">
				<button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
					<i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
				</button>
				<div class="theme-settings__inner">
					<div class="scrollbar-container">
						<div class="theme-settings__options-wrapper">
							<h3 class="themeoptions-heading">
								Layout Options
							</h3>
							<div class="p-3">
								<ul class="list-group">
									<li class="list-group-item">
										<div class="widget-content p-0">
											<div class="widget-content-wrapper">
												<div class="widget-content-left mr-3">
													<div class="switch has-switch switch-container-class" data-class="fixed-header">
														<div class="switch-animate switch-on">
															<input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
														</div>
													</div>
												</div>
												<div class="widget-content-left">
													<div class="widget-heading">Fixed Header
													</div>
													<div class="widget-subheading">Makes the header top fixed, always visible!
													</div>
												</div>
											</div>
										</div>
									</li>
									<li class="list-group-item">
										<div class="widget-content p-0">
											<div class="widget-content-wrapper">
												<div class="widget-content-left mr-3">
													<div class="switch has-switch switch-container-class" data-class="fixed-sidebar">
														<div class="switch-animate switch-on">
															<input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
														</div>
													</div>
												</div>
												<div class="widget-content-left">
													<div class="widget-heading">Fixed Sidebar
													</div>
													<div class="widget-subheading">Makes the sidebar left fixed, always visible!
													</div>
												</div>
											</div>
										</div>
									</li>
									<li class="list-group-item">
										<div class="widget-content p-0">
											<div class="widget-content-wrapper">
												<div class="widget-content-left mr-3">
													<div class="switch has-switch switch-container-class" data-class="fixed-footer">
														<div class="switch-animate switch-off">
															<input type="checkbox" data-toggle="toggle" data-onstyle="success">
														</div>
													</div>
												</div>
												<div class="widget-content-left">
													<div class="widget-heading">Fixed Footer
													</div>
													<div class="widget-subheading">Makes the app footer bottom fixed, always visible!
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
							<h3 class="themeoptions-heading">
								<div>Header Options</div>
								<button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class" data-class="">
									Restore Default
								</button>
							</h3>
							<div class="p-3">
								<ul class="list-group">
									<li class="list-group-item">
										<h5 class="pb-2">
											Choose Color Scheme
										</h5>
										<div class="theme-settings-swatches">
											<div class="swatch-holder bg-primary switch-header-cs-class" data-class="bg-primary header-text-light">
											</div>
											<div class="swatch-holder bg-secondary switch-header-cs-class" data-class="bg-secondary header-text-light">
											</div>
											<div class="swatch-holder bg-success switch-header-cs-class" data-class="bg-success header-text-dark">
											</div>
											<div class="swatch-holder bg-info switch-header-cs-class" data-class="bg-info header-text-dark">
											</div>
											<div class="swatch-holder bg-warning switch-header-cs-class" data-class="bg-warning header-text-dark">
											</div>
											<div class="swatch-holder bg-danger switch-header-cs-class" data-class="bg-danger header-text-light">
											</div>
											<div class="swatch-holder bg-light switch-header-cs-class" data-class="bg-light header-text-dark">
											</div>
											<div class="swatch-holder bg-dark switch-header-cs-class" data-class="bg-dark header-text-light">
											</div>
											<div class="swatch-holder bg-focus switch-header-cs-class" data-class="bg-focus header-text-light">
											</div>
											<div class="swatch-holder bg-alternate switch-header-cs-class" data-class="bg-alternate header-text-light">
											</div>
											<div class="divider">
											</div>
											<div class="swatch-holder bg-vicious-stance switch-header-cs-class" data-class="bg-vicious-stance header-text-light">
											</div>
											<div class="swatch-holder bg-midnight-bloom switch-header-cs-class" data-class="bg-midnight-bloom header-text-light">
											</div>
											<div class="swatch-holder bg-night-sky switch-header-cs-class" data-class="bg-night-sky header-text-light">
											</div>
											<div class="swatch-holder bg-slick-carbon switch-header-cs-class" data-class="bg-slick-carbon header-text-light">
											</div>
											<div class="swatch-holder bg-asteroid switch-header-cs-class" data-class="bg-asteroid header-text-light">
											</div>
											<div class="swatch-holder bg-royal switch-header-cs-class" data-class="bg-royal header-text-light">
											</div>
											<div class="swatch-holder bg-warm-flame switch-header-cs-class" data-class="bg-warm-flame header-text-dark">
											</div>
											<div class="swatch-holder bg-night-fade switch-header-cs-class" data-class="bg-night-fade header-text-dark">
											</div>
											<div class="swatch-holder bg-sunny-morning switch-header-cs-class" data-class="bg-sunny-morning header-text-dark">
											</div>
											<div class="swatch-holder bg-tempting-azure switch-header-cs-class" data-class="bg-tempting-azure header-text-dark">
											</div>
											<div class="swatch-holder bg-amy-crisp switch-header-cs-class" data-class="bg-amy-crisp header-text-dark">
											</div>
											<div class="swatch-holder bg-heavy-rain switch-header-cs-class" data-class="bg-heavy-rain header-text-dark">
											</div>
											<div class="swatch-holder bg-mean-fruit switch-header-cs-class" data-class="bg-mean-fruit header-text-dark">
											</div>
											<div class="swatch-holder bg-malibu-beach switch-header-cs-class" data-class="bg-malibu-beach header-text-light">
											</div>
											<div class="swatch-holder bg-deep-blue switch-header-cs-class" data-class="bg-deep-blue header-text-dark">
											</div>
											<div class="swatch-holder bg-ripe-malin switch-header-cs-class" data-class="bg-ripe-malin header-text-light">
											</div>
											<div class="swatch-holder bg-arielle-smile switch-header-cs-class" data-class="bg-arielle-smile header-text-light">
											</div>
											<div class="swatch-holder bg-plum-plate switch-header-cs-class" data-class="bg-plum-plate header-text-light">
											</div>
											<div class="swatch-holder bg-happy-fisher switch-header-cs-class" data-class="bg-happy-fisher header-text-dark">
											</div>
											<div class="swatch-holder bg-happy-itmeo switch-header-cs-class" data-class="bg-happy-itmeo header-text-light">
											</div>
											<div class="swatch-holder bg-mixed-hopes switch-header-cs-class" data-class="bg-mixed-hopes header-text-light">
											</div>
											<div class="swatch-holder bg-strong-bliss switch-header-cs-class" data-class="bg-strong-bliss header-text-light">
											</div>
											<div class="swatch-holder bg-grow-early switch-header-cs-class" data-class="bg-grow-early header-text-light">
											</div>
											<div class="swatch-holder bg-love-kiss switch-header-cs-class" data-class="bg-love-kiss header-text-light">
											</div>
											<div class="swatch-holder bg-premium-dark switch-header-cs-class" data-class="bg-premium-dark header-text-light">
											</div>
											<div class="swatch-holder bg-happy-green switch-header-cs-class" data-class="bg-happy-green header-text-light">
											</div>
										</div>
									</li>
								</ul>
							</div>
							<h3 class="themeoptions-heading">
								<div>Sidebar Options</div>
								<button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class" data-class="">
									Restore Default
								</button>
							</h3>
							<div class="p-3">
								<ul class="list-group">
									<li class="list-group-item">
										<h5 class="pb-2">
											Choose Color Scheme
										</h5>
										<div class="theme-settings-swatches">
											<div class="swatch-holder bg-primary switch-sidebar-cs-class" data-class="bg-primary sidebar-text-light">
											</div>
											<div class="swatch-holder bg-secondary switch-sidebar-cs-class" data-class="bg-secondary sidebar-text-light">
											</div>
											<div class="swatch-holder bg-success switch-sidebar-cs-class" data-class="bg-success sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-info switch-sidebar-cs-class" data-class="bg-info sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-warning switch-sidebar-cs-class" data-class="bg-warning sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-danger switch-sidebar-cs-class" data-class="bg-danger sidebar-text-light">
											</div>
											<div class="swatch-holder bg-light switch-sidebar-cs-class" data-class="bg-light sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-dark switch-sidebar-cs-class" data-class="bg-dark sidebar-text-light">
											</div>
											<div class="swatch-holder bg-focus switch-sidebar-cs-class" data-class="bg-focus sidebar-text-light">
											</div>
											<div class="swatch-holder bg-alternate switch-sidebar-cs-class" data-class="bg-alternate sidebar-text-light">
											</div>
											<div class="divider">
											</div>
											<div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class" data-class="bg-vicious-stance sidebar-text-light">
											</div>
											<div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class" data-class="bg-midnight-bloom sidebar-text-light">
											</div>
											<div class="swatch-holder bg-night-sky switch-sidebar-cs-class" data-class="bg-night-sky sidebar-text-light">
											</div>
											<div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class" data-class="bg-slick-carbon sidebar-text-light">
											</div>
											<div class="swatch-holder bg-asteroid switch-sidebar-cs-class" data-class="bg-asteroid sidebar-text-light">
											</div>
											<div class="swatch-holder bg-royal switch-sidebar-cs-class" data-class="bg-royal sidebar-text-light">
											</div>
											<div class="swatch-holder bg-warm-flame switch-sidebar-cs-class" data-class="bg-warm-flame sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-night-fade switch-sidebar-cs-class" data-class="bg-night-fade sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class" data-class="bg-sunny-morning sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class" data-class="bg-tempting-azure sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class" data-class="bg-amy-crisp sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class" data-class="bg-heavy-rain sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class" data-class="bg-mean-fruit sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class" data-class="bg-malibu-beach sidebar-text-light">
											</div>
											<div class="swatch-holder bg-deep-blue switch-sidebar-cs-class" data-class="bg-deep-blue sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class" data-class="bg-ripe-malin sidebar-text-light">
											</div>
											<div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class" data-class="bg-arielle-smile sidebar-text-light">
											</div>
											<div class="swatch-holder bg-plum-plate switch-sidebar-cs-class" data-class="bg-plum-plate sidebar-text-light">
											</div>
											<div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class" data-class="bg-happy-fisher sidebar-text-dark">
											</div>
											<div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class" data-class="bg-happy-itmeo sidebar-text-light">
											</div>
											<div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class" data-class="bg-mixed-hopes sidebar-text-light">
											</div>
											<div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class" data-class="bg-strong-bliss sidebar-text-light">
											</div>
											<div class="swatch-holder bg-grow-early switch-sidebar-cs-class" data-class="bg-grow-early sidebar-text-light">
											</div>
											<div class="swatch-holder bg-love-kiss switch-sidebar-cs-class" data-class="bg-love-kiss sidebar-text-light">
											</div>
											<div class="swatch-holder bg-premium-dark switch-sidebar-cs-class" data-class="bg-premium-dark sidebar-text-light">
											</div>
											<div class="swatch-holder bg-happy-green switch-sidebar-cs-class" data-class="bg-happy-green sidebar-text-light">
											</div>
										</div>
									</li>
								</ul>
							</div>
							<h3 class="themeoptions-heading">
								<div>Main Content Options</div>
								<button type="button" class="btn-pill btn-shadow btn-wide ml-auto active btn btn-focus btn-sm">Restore Default
								</button>
							</h3>
							<div class="p-3">
								<ul class="list-group">
									<li class="list-group-item">
										<h5 class="pb-2">
											Page Section Tabs
										</h5>
										<div class="theme-settings-swatches">
											<div role="group" class="mt-2 btn-group">
												<button type="button" class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class" data-class="body-tabs-line">
													Line
												</button>
												<button type="button" class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class" data-class="body-tabs-shadow">
													Shadow
												</button>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="app-main">
				<div class="app-sidebar sidebar-shadow">
					<div class="app-header__logo">
						<div class="logo-src"></div>
						<div class="header__pane ml-auto">
							<div>
								<button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
									<span class="hamburger-box">
										<span class="hamburger-inner"></span>
									</span>
								</button>
							</div>
						</div>
					</div>
					<div class="app-header__mobile-menu">
						<div>
							<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
								<span class="hamburger-box">
									<span class="hamburger-inner"></span>
								</span>
							</button>
						</div>
					</div>
					<div class="app-header__menu">
						<span>
							<button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
								<span class="btn-icon-wrapper">
									<i class="fa fa-ellipsis-v fa-w-6"></i>
								</span>
							</button>
						</span>
					</div>
					<div class="scrollbar-sidebar">
						<div class="app-sidebar__inner">
							<ul class="vertical-nav-menu">
								<li class="app-sidebar__heading">Вводи</li>
								<li <?php if ($menu === 'main'): ?> class="mm-active" <?php endif; ?>>
									<a href="/">
										<i class="metismenu-icon pe-7s-graph3"></i>
										Головна
									</a>
								</li>
								<li <?php if ($menu === 'passports'): ?> class="mm-active" <?php endif; ?>>
									<a href="/passports/index">
										<i class="metismenu-icon pe-7s-note2"></i>
										Паспорти
									</a>
								</li>
								<?php if ($this->session->user->id == 1): ?>
								<li <?php if ($menu === 'users'): ?> class="mm-active" <?php endif; ?>>
									<a href="/users">
										<i class="metismenu-icon pe-7s-users"></i>
										Користувачі
									</a>
								</li>
								<li <?php if ($menu === 'users_rights'): ?> class="mm-active" <?php endif; ?>>
									<a href="/users_rights">
										<i class="metismenu-icon pe-7s-key"></i>
										Права користувачів
									</a>
								</li>
								<?php endif; ?>
								<?php //if ($this->session->user->id == 1): ?>
								<!-- <li <?php //if ($menu === 'import'): ?> class="mm-active" <?php //endif; ?>>
									<a href="/import/index">
										<i class="metismenu-icon pe-7s-display2"></i>
										Імпорт даних
									</a>
								</li> -->
								<?php //endif; ?>

								<li class="app-sidebar__heading">Списки</li>
								<li>
									<a href="javascript:void(0);">
										<i class="metismenu-icon pe-7s-notebook"></i>
										Таблиці
										<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
									</a>
									<ul class="mm-collapse">
										<li <?php if ($menu === 'companies'): ?> class="mm-active" <?php endif; ?>>
											<a href="javascript:void(0);">
												<i class="metismenu-icon"></i>
												Компанії
											</a>
										</li>
										<li <?php if ($menu === 'filials'): ?> class="mm-active" <?php endif; ?>>
											<a href="javascript:void(0);">
												<i class="metismenu-icon"></i>
												Підрозділи
											</a>
										</li>
										<li <?php if ($menu === 'stantions'): ?> class="mm-active" <?php endif; ?>>
											<a href="/stantions">
												<i class="metismenu-icon"></i>
												Підстанції
											</a>
										</li>
										<li <?php if ($menu === 'disps'): ?> class="mm-active" <?php endif; ?>>
											<a href="javascript:void(0);">
												<i class="metismenu-icon"></i>
												Дисп. найменування
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>    
				<div class="app-main__outer">
					<div class="app-main__inner">
						<div class="app-page-title">
							<div class="page-title-wrapper">
								<div class="page-title-heading">
									<div class="page-title-icon">
										<i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
										</i>
									</div>
									<div>
										<?php echo $title_heading; ?>
										<div class="page-title-subheading">
											<?php echo $title_subheading; ?>
										</div>
									</div>
								</div>
								<div class="page-title-actions">
									<?php if (isset($button_back) && $button_back): ?>
										<a href="<?php echo isset($button_back_href) ? $button_back_href : '/'; ?>" class="btn-transition btn btn-outline-info"><?php echo isset($button_back_title) ? $button_back_title : 'Назад'; ?></a>
									<?php endif; ?>
									<?php if (isset($button_create) && $button_create): ?>
										<a href="<?php echo isset($button_create_href) ? $button_create_href : '/'; ?>" class="btn-transition btn btn-outline-secondary">Створити</a>
									<?php endif; ?>

									<button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark" style="display: none;">
										<i class="fa fa-star"></i>
									</button>
									<div class="d-inline-block dropdown">
										<button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info" style="display: none;">
											<span class="btn-icon-wrapper pr-2 opacity-7">
												<i class="fa fa-business-time fa-w-20"></i>
											</span>
											Buttons
										</button>
										<div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
											<ul class="nav flex-column">
												<li class="nav-item">
													<a href="javascript:void(0);" class="nav-link">
														<i class="nav-link-icon lnr-inbox"></i>
														<span>
															Inbox
														</span>
														<div class="ml-auto badge badge-pill badge-secondary">86</div>
													</a>
												</li>
												<li class="nav-item">
													<a href="javascript:void(0);" class="nav-link">
														<i class="nav-link-icon lnr-book"></i>
														<span>
															Book
														</span>
														<div class="ml-auto badge badge-pill badge-danger">5</div>
													</a>
												</li>
												<li class="nav-item">
													<a href="javascript:void(0);" class="nav-link">
														<i class="nav-link-icon lnr-picture"></i>
														<span>
															Picture
														</span>
													</a>
												</li>
												<li class="nav-item">
													<a disabled href="javascript:void(0);" class="nav-link disabled">
														<i class="nav-link-icon lnr-file-empty"></i>
														<span>
															File Disabled
														</span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php $this->load->view($content); ?>
					</div>
					<div class="app-wrapper-footer">
						<div class="app-footer">
							<div class="app-footer__inner">
								<div class="app-footer-left">
									<ul class="nav">
										<li class="nav-item">
											<a href="javascript:void(0);" class="nav-link">
												Footer Link 1
											</a>
										</li>
										<li class="nav-item">
											<a href="javascript:void(0);" class="nav-link">
												Footer Link 2
											</a>
										</li>
									</ul>
								</div>
								<div class="app-footer-right">
									<ul class="nav">
										<li class="nav-item">
											<a href="javascript:void(0);" class="nav-link">
												Footer Link 3
											</a>
										</li>
										<li class="nav-item">
											<a href="javascript:void(0);" class="nav-link">
												<div class="badge badge-success mr-1 ml-0">
													<small>NEW</small>
												</div>
												Footer Link 4
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> 

		<script src="/libs/perfect-scrollbar/dist/perfect-scrollbar.js"></script>
		<script src="/libs/metismenu/dist/metisMenu.min.js"></script>
		<script src="/libs/toastr/build/toastr.min.js"></script>

		<script src="/assets/js/aui.js"></script>

		<?php if ($page_js === 'bushings_main'): ?>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
			<script src="/assets/js/pages/bushings/main.js?v=<?php echo time(); ?>"></script>
		<?php endif; ?>

		<?php if ($page_js === 'bushings_tests'): ?>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
			<script src="/assets/js/pages/bushings/tests.js"></script>
		<?php endif; ?>

		<?php if ($page_js === 'bushings_create_passport'): ?>
			<!-- <script src="/assets/js/pages/bushings/create_passport.js"></script> -->
		<?php endif; ?>

		<?php if ($page_js === 'bushings_update_passport'): ?>
			<script src="/assets/js/pages/bushings/update_passport.js"></script>
		<?php endif; ?>

		<?php if ($page_js === 'bushings_create_test'): ?>
			<script src="/assets/js/pages/bushings/create_test.js"></script>
		<?php endif; ?>

		<script>
			$(document).ready(function() {
				$('#codeigniter_profiler').css({'position': 'absolute', 'left': '280px'});
			});
		</script>
	</body>
</html>

<?php if ($menu === 'tests'): ?>
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalTest">
		<div class="modal-dialog modal-dialog-scrollable modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Детальна інформація про випробування</h5>
					<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
						<!-- <span aria-hidden="true">&times;</span> -->
					<!-- </button> -->
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
					<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if ($page === 'main'): ?>
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="mailModal">
		<div class="modal-dialog modal-dialog-scrollable modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Відправлення листа розробнику</h5>
					<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
						<!-- <span aria-hidden="true">&times;</span> -->
					<!-- </button> -->
				</div>
				<div class="modal-body">
					<form id="formMailModal">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label for="inputMailName" class="">Ім`я</label>
									<input type="text" name="name" placeholder="Ведіть ім`я" class="form-control" id="inputMailName" required>	
								</div>
								<div class="form-group">
									<label for="inputMailSubject" class="">Тема</label>
									<input type="text" name="subject" placeholder="Введіть тему" class="form-control" id="inputMailSubject" required>	
								</div>
								<div class="form-group">
									<label for="inputMailMessage" class="">Повідомлення</label>
									<textarea name="message" placeholder="Введіть повідомлення" class="form-control" id="inputMailMessage" rows="5" required></textarea>	
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
					<button type="button" class="btn btn-primary" id="buttonMailModal">Відправити</button>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>