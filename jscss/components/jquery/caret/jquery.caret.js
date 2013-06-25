  


<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# githubog: http://ogp.me/ns/fb/githubog#">
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>jquery-caret/jquery.caret.js at master · DrPheltRight/jquery-caret</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub" />
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-144.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144.png" />
    <link rel="logo" type="image/svg" href="http://github-media-downloads.s3.amazonaws.com/github-logo.svg" />
    <link rel="assets" href="https://a248.e.akamai.net/assets.github.com/">
    <link rel="xhr-socket" href="/_sockets" />
    


    <meta name="msapplication-TileImage" content="/windows-tile.png" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="selected-link" value="repo_source" data-pjax-transient />
    <meta content="collector.githubapp.com" name="octolytics-host" /><meta content="github" name="octolytics-app-id" /><meta content="3153287" name="octolytics-actor-id" /><meta content="PeterZhukov" name="octolytics-actor-login" /><meta content="57a33a59a00a8761a5ad0b095c681cd8bbc5dc2f7f45ff0c9a6afe56057c368f" name="octolytics-actor-hash" />

    
    
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />

    <meta content="authenticity_token" name="csrf-param" />
<meta content="fmgYQZQZQYvVy9xlfZtayVx6kmyZUjR3SY/EmNM8AYQ=" name="csrf-token" />

    <link href="https://a248.e.akamai.net/assets.github.com/assets/github-0c2e6b2f619f4aafd0dc861f56d66b8fc3b130eb.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://a248.e.akamai.net/assets.github.com/assets/github2-825f026ec649c1aabce8f2d0390fc4d3bb870964.css" media="all" rel="stylesheet" type="text/css" />
    


      <script src="https://a248.e.akamai.net/assets.github.com/assets/frameworks-4c434fa1705bf526e191eec0cd8fab1a5ce3e326.js" type="text/javascript"></script>
      <script src="https://a248.e.akamai.net/assets.github.com/assets/github-fa0e576ffff9e151472d56e5f4512a9053a68a12.js" type="text/javascript"></script>
      
      <meta http-equiv="x-pjax-version" content="51c0b4a5726a8cb47213bcf36c3dd471">

        <link data-pjax-transient rel='permalink' href='/DrPheltRight/jquery-caret/blob/20803a7a164a147ea513c68fd7aadbcf884100f8/jquery.caret.js'>
    <meta property="og:title" content="jquery-caret"/>
    <meta property="og:type" content="githubog:gitrepository"/>
    <meta property="og:url" content="https://github.com/DrPheltRight/jquery-caret"/>
    <meta property="og:image" content="https://secure.gravatar.com/avatar/e7f62d126dec76b03e6d2393e44247ad?s=420&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png"/>
    <meta property="og:site_name" content="GitHub"/>
    <meta property="og:description" content="jquery-caret - Simple caret moving mofo jQuery plugin."/>
    <meta property="twitter:card" content="summary"/>
    <meta property="twitter:site" content="@GitHub">
    <meta property="twitter:title" content="DrPheltRight/jquery-caret"/>

    <meta name="description" content="jquery-caret - Simple caret moving mofo jQuery plugin." />


    <meta content="272640" name="octolytics-dimension-user_id" /><meta content="DrPheltRight" name="octolytics-dimension-user_login" /><meta content="1847409" name="octolytics-dimension-repository_id" /><meta content="DrPheltRight/jquery-caret" name="octolytics-dimension-repository_nwo" /><meta content="true" name="octolytics-dimension-repository_public" /><meta content="false" name="octolytics-dimension-repository_is_fork" /><meta content="1847409" name="octolytics-dimension-repository_network_root_id" /><meta content="DrPheltRight/jquery-caret" name="octolytics-dimension-repository_network_root_nwo" />
  <link href="https://github.com/DrPheltRight/jquery-caret/commits/master.atom" rel="alternate" title="Recent Commits to jquery-caret:master" type="application/atom+xml" />

  </head>


  <body class="logged_in page-blob windows vis-public env-production  ">
    <div id="wrapper">

      
      
      

      <div class="header header-logged-in true">
  <div class="container clearfix">

    <a class="header-logo-invertocat" href="https://github.com/">
  <span class="mega-octicon octicon-mark-github"></span>
</a>

    <div class="divider-vertical"></div>

      <a href="/notifications" class="notification-indicator tooltipped downwards" title="You have no unread notifications">
    <span class="mail-status all-read"></span>
  </a>
  <div class="divider-vertical"></div>


      <div class="command-bar js-command-bar  in-repository">
          <form accept-charset="UTF-8" action="/search" class="command-bar-form" id="top_search_form" method="get">
  <a href="/search/advanced" class="advanced-search-icon tooltipped downwards command-bar-search" id="advanced_search" title="Advanced search"><span class="octicon octicon-gear "></span></a>

  <input type="text" data-hotkey="/ s" name="q" id="js-command-bar-field" placeholder="Search or type a command" tabindex="1" autocapitalize="off"
    data-username="PeterZhukov"
      data-repo="DrPheltRight/jquery-caret"
      data-branch="master"
      data-sha="c2200193b0f9b6699718cd662e1050a7d109c34c"
  >

    <input type="hidden" name="nwo" value="DrPheltRight/jquery-caret" />

    <div class="select-menu js-menu-container js-select-menu search-context-select-menu">
      <span class="minibutton select-menu-button js-menu-target">
        <span class="js-select-button">This repository</span>
      </span>

      <div class="select-menu-modal-holder js-menu-content js-navigation-container">
        <div class="select-menu-modal">

          <div class="select-menu-item js-navigation-item selected">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" class="js-search-this-repository" name="search_target" value="repository" checked="checked" />
            <div class="select-menu-item-text js-select-button-text">This repository</div>
          </div> <!-- /.select-menu-item -->

          <div class="select-menu-item js-navigation-item">
            <span class="select-menu-item-icon octicon octicon-check"></span>
            <input type="radio" name="search_target" value="global" />
            <div class="select-menu-item-text js-select-button-text">All repositories</div>
          </div> <!-- /.select-menu-item -->

        </div>
      </div>
    </div>

  <span class="octicon help tooltipped downwards" title="Show command bar help">
    <span class="octicon octicon-question"></span>
  </span>


  <input type="hidden" name="ref" value="cmdform">

  <div class="divider-vertical"></div>

</form>
        <ul class="top-nav">
            <li class="explore"><a href="/explore">Explore</a></li>
            <li><a href="https://gist.github.com">Gist</a></li>
            <li><a href="/blog">Blog</a></li>
          <li><a href="http://help.github.com">Help</a></li>
        </ul>
      </div>

    

  

    <ul id="user-links">
      <li>
        <a href="/PeterZhukov" class="name">
          <img height="20" src="https://secure.gravatar.com/avatar/0a6cc1a88b0e158cfe3125eb20bf7a6d?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="20" /> PeterZhukov
        </a>
      </li>

        <li>
          <a href="/new" id="new_repo" class="tooltipped downwards" title="Create a new repo">
            <span class="octicon octicon-repo-create"></span>
          </a>
        </li>

        <li>
          <a href="/settings/profile" id="account_settings"
            class="tooltipped downwards"
            title="Account settings ">
            <span class="octicon octicon-tools"></span>
          </a>
        </li>
        <li>
          <a class="tooltipped downwards" href="/logout" data-method="post" id="logout" title="Sign out">
            <span class="octicon octicon-log-out"></span>
          </a>
        </li>

    </ul>


<div class="js-new-dropdown-contents hidden">
  

<ul class="dropdown-menu">
  <li>
    <a href="/new"><span class="octicon octicon-repo-create"></span> New repository</a>
  </li>
  <li>
    <a href="/organizations/new"><span class="octicon octicon-list-unordered"></span> New organization</a>
  </li>



    <li class="section-title">
      This Repository
    </li>
    <li>
      <a href="/DrPheltRight/jquery-caret/issues/new"><span class="octicon octicon-issue-opened"></span> New issue</a>
    </li>
</ul>

</div>


    
  </div>
</div>

      

      


            <div class="global-notices">
      <div class="flash-global">
        <div class="container">
            <a href="/users/PeterZhukov/enable_repository_next?nwo=DrPheltRight%2Fjquery-caret" class="button minibutton flash-action blue" data-method="post">Enable Repository Next</a>

            <h2>Hey there, would you like to enable our new repository design?</h2>
            <p>We&rsquo;ve been working hard making a <a href="https://github.com/blog/1529-repository-next">faster, better repository experience</a> and we&rsquo;d love to share it with you.</p>
        </div>
      </div>
    </div>
    <div class="site hfeed" itemscope itemtype="http://schema.org/WebPage">
      <div class="hentry">
        
        <div class="pagehead repohead instapaper_ignore readability-menu ">
          <div class="container">
            <div class="title-actions-bar">
              

<ul class="pagehead-actions">


    <li class="subscription">
      <form accept-charset="UTF-8" action="/notifications/subscribe" data-autosubmit="true" data-remote="true" method="post"><div style="margin:0;padding:0;display:inline"><input name="authenticity_token" type="hidden" value="fmgYQZQZQYvVy9xlfZtayVx6kmyZUjR3SY/EmNM8AYQ=" /></div>  <input id="repository_id" name="repository_id" type="hidden" value="1847409" />

    <div class="select-menu js-menu-container js-select-menu">
      <span class="minibutton select-menu-button  js-menu-target">
        <span class="js-select-button">
          <span class="octicon octicon-eye-watch"></span>
          Watch
        </span>
      </span>

      <div class="select-menu-modal-holder">
        <div class="select-menu-modal subscription-menu-modal js-menu-content">
          <div class="select-menu-header">
            <span class="select-menu-title">Notification status</span>
            <span class="octicon octicon-remove-close js-menu-close"></span>
          </div> <!-- /.select-menu-header -->

          <div class="select-menu-list js-navigation-container">

            <div class="select-menu-item js-navigation-item selected">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <div class="select-menu-item-text">
                <input checked="checked" id="do_included" name="do" type="radio" value="included" />
                <h4>Not watching</h4>
                <span class="description">You only receive notifications for discussions in which you participate or are @mentioned.</span>
                <span class="js-select-button-text hidden-select-button-text">
                  <span class="octicon octicon-eye-watch"></span>
                  Watch
                </span>
              </div>
            </div> <!-- /.select-menu-item -->

            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon octicon-check"></span>
              <div class="select-menu-item-text">
                <input id="do_subscribed" name="do" type="radio" value="subscribed" />
                <h4>Watching</h4>
                <span class="description">You receive notifications for all discussions in this repository.</span>
                <span class="js-select-button-text hidden-select-button-text">
                  <span class="octicon octicon-eye-unwatch"></span>
                  Unwatch
                </span>
              </div>
            </div> <!-- /.select-menu-item -->

            <div class="select-menu-item js-navigation-item ">
              <span class="select-menu-item-icon octicon octicon-check"></span>
              <div class="select-menu-item-text">
                <input id="do_ignore" name="do" type="radio" value="ignore" />
                <h4>Ignoring</h4>
                <span class="description">You do not receive any notifications for discussions in this repository.</span>
                <span class="js-select-button-text hidden-select-button-text">
                  <span class="octicon octicon-mute"></span>
                  Stop ignoring
                </span>
              </div>
            </div> <!-- /.select-menu-item -->

          </div> <!-- /.select-menu-list -->

        </div> <!-- /.select-menu-modal -->
      </div> <!-- /.select-menu-modal-holder -->
    </div> <!-- /.select-menu -->

</form>
    </li>

    <li class="js-toggler-container js-social-container starring-container ">
      <a href="/DrPheltRight/jquery-caret/unstar" class="minibutton with-count js-toggler-target star-button starred upwards" title="Unstar this repo" data-remote="true" data-method="post" rel="nofollow">
        <span class="octicon octicon-star-delete"></span>
        <span class="text">Unstar</span>
      </a>
      <a href="/DrPheltRight/jquery-caret/star" class="minibutton with-count js-toggler-target star-button unstarred upwards" title="Star this repo" data-remote="true" data-method="post" rel="nofollow">
        <span class="octicon octicon-star"></span>
        <span class="text">Star</span>
      </a>
      <a class="social-count js-social-count" href="/DrPheltRight/jquery-caret/stargazers">54</a>
    </li>

        <li>
          <a href="/DrPheltRight/jquery-caret/fork" class="minibutton with-count js-toggler-target fork-button lighter upwards" title="Fork this repo" rel="nofollow" data-method="post">
            <span class="octicon octicon-git-branch-create"></span>
            <span class="text">Fork</span>
          </a>
          <a href="/DrPheltRight/jquery-caret/network" class="social-count">21</a>
        </li>


</ul>

              <h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="entry-title public">
                <span class="repo-label"><span>public</span></span>
                <span class="mega-octicon octicon-repo"></span>
                <span class="author vcard">
                  <a href="/DrPheltRight" class="url fn" itemprop="url" rel="author">
                  <span itemprop="title">DrPheltRight</span>
                  </a></span> /
                <strong><a href="/DrPheltRight/jquery-caret" class="js-current-repository">jquery-caret</a></strong>
              </h1>
            </div>

            
  <ul class="tabs">
    <li class="pulse-nav"><a href="/DrPheltRight/jquery-caret/pulse" class="js-selected-navigation-item " data-selected-links="pulse /DrPheltRight/jquery-caret/pulse" rel="nofollow"><span class="octicon octicon-pulse"></span></a></li>
    <li><a href="/DrPheltRight/jquery-caret" class="js-selected-navigation-item selected" data-selected-links="repo_source repo_downloads repo_commits repo_tags repo_branches /DrPheltRight/jquery-caret">Code</a></li>
    <li><a href="/DrPheltRight/jquery-caret/network" class="js-selected-navigation-item " data-selected-links="repo_network /DrPheltRight/jquery-caret/network">Network</a></li>
    <li><a href="/DrPheltRight/jquery-caret/pulls" class="js-selected-navigation-item " data-selected-links="repo_pulls /DrPheltRight/jquery-caret/pulls">Pull Requests <span class='counter'>1</span></a></li>

      <li><a href="/DrPheltRight/jquery-caret/issues" class="js-selected-navigation-item " data-selected-links="repo_issues /DrPheltRight/jquery-caret/issues">Issues <span class='counter'>2</span></a></li>

      <li><a href="/DrPheltRight/jquery-caret/wiki" class="js-selected-navigation-item " data-selected-links="repo_wiki /DrPheltRight/jquery-caret/wiki">Wiki</a></li>


    <li><a href="/DrPheltRight/jquery-caret/graphs" class="js-selected-navigation-item " data-selected-links="repo_graphs repo_contributors /DrPheltRight/jquery-caret/graphs">Graphs</a></li>


  </ul>
  
<div class="tabnav">

  <span class="tabnav-right">
    <ul class="tabnav-tabs">
          <li><a href="/DrPheltRight/jquery-caret/tags" class="js-selected-navigation-item tabnav-tab" data-selected-links="repo_tags /DrPheltRight/jquery-caret/tags">Tags <span class="counter blank">0</span></a></li>
    </ul>
  </span>

  <div class="tabnav-widget scope">


    <div class="select-menu js-menu-container js-select-menu js-branch-menu">
      <a class="minibutton select-menu-button js-menu-target" data-hotkey="w" data-ref="master">
        <span class="octicon octicon-git-branch"></span>
        <i>branch:</i>
        <span class="js-select-button">master</span>
      </a>

      <div class="select-menu-modal-holder js-menu-content js-navigation-container">

        <div class="select-menu-modal">
          <div class="select-menu-header">
            <span class="select-menu-title">Switch branches/tags</span>
            <span class="octicon octicon-remove-close js-menu-close"></span>
          </div> <!-- /.select-menu-header -->

          <div class="select-menu-filters">
            <div class="select-menu-text-filter">
              <input type="text" id="commitish-filter-field" class="js-filterable-field js-navigation-enable" placeholder="Filter branches/tags">
            </div>
            <div class="select-menu-tabs">
              <ul>
                <li class="select-menu-tab">
                  <a href="#" data-tab-filter="branches" class="js-select-menu-tab">Branches</a>
                </li>
                <li class="select-menu-tab">
                  <a href="#" data-tab-filter="tags" class="js-select-menu-tab">Tags</a>
                </li>
              </ul>
            </div><!-- /.select-menu-tabs -->
          </div><!-- /.select-menu-filters -->

          <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket css-truncate" data-tab-filter="branches">

            <div data-filterable-for="commitish-filter-field" data-filterable-type="substring">

                <div class="select-menu-item js-navigation-item ">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/DrPheltRight/jquery-caret/blob/gh-pages/jquery.caret.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="gh-pages" rel="nofollow" title="gh-pages">gh-pages</a>
                </div> <!-- /.select-menu-item -->
                <div class="select-menu-item js-navigation-item selected">
                  <span class="select-menu-item-icon octicon octicon-check"></span>
                  <a href="/DrPheltRight/jquery-caret/blob/master/jquery.caret.js" class="js-navigation-open select-menu-item-text js-select-button-text css-truncate-target" data-name="master" rel="nofollow" title="master">master</a>
                </div> <!-- /.select-menu-item -->
            </div>

              <div class="select-menu-no-results">Nothing to show</div>
          </div> <!-- /.select-menu-list -->


          <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket css-truncate" data-tab-filter="tags">
            <div data-filterable-for="commitish-filter-field" data-filterable-type="substring">

            </div>

            <div class="select-menu-no-results">Nothing to show</div>

          </div> <!-- /.select-menu-list -->

        </div> <!-- /.select-menu-modal -->
      </div> <!-- /.select-menu-modal-holder -->
    </div> <!-- /.select-menu -->

  </div> <!-- /.scope -->

  <ul class="tabnav-tabs">
    <li><a href="/DrPheltRight/jquery-caret" class="selected js-selected-navigation-item tabnav-tab" data-selected-links="repo_source /DrPheltRight/jquery-caret">Files</a></li>
    <li><a href="/DrPheltRight/jquery-caret/commits/master" class="js-selected-navigation-item tabnav-tab" data-selected-links="repo_commits /DrPheltRight/jquery-caret/commits/master">Commits</a></li>
    <li><a href="/DrPheltRight/jquery-caret/branches" class="js-selected-navigation-item tabnav-tab" data-selected-links="repo_branches /DrPheltRight/jquery-caret/branches" rel="nofollow">Branches <span class="counter ">2</span></a></li>
  </ul>

</div>

  
  
  


            
          </div>
        </div><!-- /.repohead -->

        <div id="js-repo-pjax-container" class="container context-loader-container" data-pjax-container>
          


<!-- blob contrib key: blob_contributors:v21:4ee5f3b8df543cdaf88af6622d8226a2 -->
<!-- blob contrib frag key: views10/v8/blob_contributors:v21:4ee5f3b8df543cdaf88af6622d8226a2 -->

<div id="slider">
    <div class="frame-meta">

      <p title="This is a placeholder element" class="js-history-link-replace hidden"></p>

        <a href="/DrPheltRight/jquery-caret/find/master" class="js-slide-to" data-hotkey="t" style="display:none">Show File Finder</a>

        <div class="breadcrumb">
          <span class='bold'><span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/DrPheltRight/jquery-caret" class="js-slide-to" data-branch="master" data-direction="back" itemscope="url"><span itemprop="title">jquery-caret</span></a></span></span><span class="separator"> / </span><strong class="final-path">jquery.caret.js</strong> <span class="js-zeroclipboard zeroclipboard-button" data-clipboard-text="jquery.caret.js" data-copied-hint="copied!" title="copy to clipboard"><span class="octicon octicon-clippy"></span></span>
        </div>


        
  <div class="commit file-history-tease">
    <img class="main-avatar" height="24" src="https://secure.gravatar.com/avatar/e7f62d126dec76b03e6d2393e44247ad?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
    <span class="author"><a href="/DrPheltRight" rel="author">DrPheltRight</a></span>
    <time class="js-relative-date" datetime="2011-06-05T04:25:32-07:00" title="2011-06-05 04:25:32">June 05, 2011</time>
    <div class="commit-title">
        <a href="/DrPheltRight/jquery-caret/commit/0730ae06bece1d2286f2329f3d0617461c3b4c3e" class="message">Improve consistency and a minor bug fix.</a>
    </div>

    <div class="participation">
      <p class="quickstat"><a href="#blob_contributors_box" rel="facebox"><strong>1</strong> contributor</a></p>
      
    </div>
    <div id="blob_contributors_box" style="display:none">
      <h2>Users on GitHub who have contributed to this file</h2>
      <ul class="facebox-user-list">
        <li>
          <img height="24" src="https://secure.gravatar.com/avatar/e7f62d126dec76b03e6d2393e44247ad?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png" width="24" />
          <a href="/DrPheltRight">DrPheltRight</a>
        </li>
      </ul>
    </div>
  </div>


    </div><!-- ./.frame-meta -->

    <div class="frames">
      <div class="frame" data-permalink-url="/DrPheltRight/jquery-caret/blob/20803a7a164a147ea513c68fd7aadbcf884100f8/jquery.caret.js" data-title="jquery-caret/jquery.caret.js at master · DrPheltRight/jquery-caret · GitHub" data-type="blob">

        <div id="files" class="bubble">
          <div class="file">
            <div class="meta">
              <div class="info">
                <span class="icon"><b class="octicon octicon-file-text"></b></span>
                <span class="mode" title="File Mode">file</span>
                  <span>79 lines (69 sloc)</span>
                <span>2.392 kb</span>
              </div>
              <div class="actions">
                <div class="button-group">
                        <a class="minibutton tooltipped leftwards"
                           title="Clicking this button will automatically fork this project so you can edit the file"
                           href="/DrPheltRight/jquery-caret/edit/master/jquery.caret.js"
                           data-method="post" rel="nofollow">Edit</a>
                  <a href="/DrPheltRight/jquery-caret/raw/master/jquery.caret.js" class="button minibutton " id="raw-url">Raw</a>
                    <a href="/DrPheltRight/jquery-caret/blame/master/jquery.caret.js" class="button minibutton ">Blame</a>
                  <a href="/DrPheltRight/jquery-caret/commits/master/jquery.caret.js" class="button minibutton " rel="nofollow">History</a>
                </div><!-- /.button-group -->
              </div><!-- /.actions -->

            </div>
                <div class="blob-wrapper data type-javascript js-blob-data">
      <table class="file-code file-diff">
        <tr class="file-code-line">
          <td class="blob-line-nums">
            <span id="L1" rel="#L1">1</span>
<span id="L2" rel="#L2">2</span>
<span id="L3" rel="#L3">3</span>
<span id="L4" rel="#L4">4</span>
<span id="L5" rel="#L5">5</span>
<span id="L6" rel="#L6">6</span>
<span id="L7" rel="#L7">7</span>
<span id="L8" rel="#L8">8</span>
<span id="L9" rel="#L9">9</span>
<span id="L10" rel="#L10">10</span>
<span id="L11" rel="#L11">11</span>
<span id="L12" rel="#L12">12</span>
<span id="L13" rel="#L13">13</span>
<span id="L14" rel="#L14">14</span>
<span id="L15" rel="#L15">15</span>
<span id="L16" rel="#L16">16</span>
<span id="L17" rel="#L17">17</span>
<span id="L18" rel="#L18">18</span>
<span id="L19" rel="#L19">19</span>
<span id="L20" rel="#L20">20</span>
<span id="L21" rel="#L21">21</span>
<span id="L22" rel="#L22">22</span>
<span id="L23" rel="#L23">23</span>
<span id="L24" rel="#L24">24</span>
<span id="L25" rel="#L25">25</span>
<span id="L26" rel="#L26">26</span>
<span id="L27" rel="#L27">27</span>
<span id="L28" rel="#L28">28</span>
<span id="L29" rel="#L29">29</span>
<span id="L30" rel="#L30">30</span>
<span id="L31" rel="#L31">31</span>
<span id="L32" rel="#L32">32</span>
<span id="L33" rel="#L33">33</span>
<span id="L34" rel="#L34">34</span>
<span id="L35" rel="#L35">35</span>
<span id="L36" rel="#L36">36</span>
<span id="L37" rel="#L37">37</span>
<span id="L38" rel="#L38">38</span>
<span id="L39" rel="#L39">39</span>
<span id="L40" rel="#L40">40</span>
<span id="L41" rel="#L41">41</span>
<span id="L42" rel="#L42">42</span>
<span id="L43" rel="#L43">43</span>
<span id="L44" rel="#L44">44</span>
<span id="L45" rel="#L45">45</span>
<span id="L46" rel="#L46">46</span>
<span id="L47" rel="#L47">47</span>
<span id="L48" rel="#L48">48</span>
<span id="L49" rel="#L49">49</span>
<span id="L50" rel="#L50">50</span>
<span id="L51" rel="#L51">51</span>
<span id="L52" rel="#L52">52</span>
<span id="L53" rel="#L53">53</span>
<span id="L54" rel="#L54">54</span>
<span id="L55" rel="#L55">55</span>
<span id="L56" rel="#L56">56</span>
<span id="L57" rel="#L57">57</span>
<span id="L58" rel="#L58">58</span>
<span id="L59" rel="#L59">59</span>
<span id="L60" rel="#L60">60</span>
<span id="L61" rel="#L61">61</span>
<span id="L62" rel="#L62">62</span>
<span id="L63" rel="#L63">63</span>
<span id="L64" rel="#L64">64</span>
<span id="L65" rel="#L65">65</span>
<span id="L66" rel="#L66">66</span>
<span id="L67" rel="#L67">67</span>
<span id="L68" rel="#L68">68</span>
<span id="L69" rel="#L69">69</span>
<span id="L70" rel="#L70">70</span>
<span id="L71" rel="#L71">71</span>
<span id="L72" rel="#L72">72</span>
<span id="L73" rel="#L73">73</span>
<span id="L74" rel="#L74">74</span>
<span id="L75" rel="#L75">75</span>
<span id="L76" rel="#L76">76</span>
<span id="L77" rel="#L77">77</span>
<span id="L78" rel="#L78">78</span>
<span id="L79" rel="#L79">79</span>

          </td>
          <td class="blob-line-code">
                  <div class="highlight"><pre><div class='line' id='LC1'><span class="c1">// Set caret position easily in jQuery</span></div><div class='line' id='LC2'><span class="c1">// Written by and Copyright of Luke Morton, 2011</span></div><div class='line' id='LC3'><span class="c1">// Licensed under MIT</span></div><div class='line' id='LC4'><span class="p">(</span><span class="kd">function</span> <span class="p">(</span><span class="nx">$</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC5'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// Behind the scenes method deals with browser</span></div><div class='line' id='LC6'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// idiosyncrasies and such</span></div><div class='line' id='LC7'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">$</span><span class="p">.</span><span class="nx">caretTo</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">(</span><span class="nx">el</span><span class="p">,</span> <span class="nx">index</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC8'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">if</span> <span class="p">(</span><span class="nx">el</span><span class="p">.</span><span class="nx">createTextRange</span><span class="p">)</span> <span class="p">{</span> </div><div class='line' id='LC9'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kd">var</span> <span class="nx">range</span> <span class="o">=</span> <span class="nx">el</span><span class="p">.</span><span class="nx">createTextRange</span><span class="p">();</span> </div><div class='line' id='LC10'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">range</span><span class="p">.</span><span class="nx">move</span><span class="p">(</span><span class="s2">&quot;character&quot;</span><span class="p">,</span> <span class="nx">index</span><span class="p">);</span> </div><div class='line' id='LC11'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">range</span><span class="p">.</span><span class="nx">select</span><span class="p">();</span> </div><div class='line' id='LC12'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">el</span><span class="p">.</span><span class="nx">selectionStart</span> <span class="o">!=</span> <span class="kc">null</span><span class="p">)</span> <span class="p">{</span> </div><div class='line' id='LC13'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">el</span><span class="p">.</span><span class="nx">focus</span><span class="p">();</span> </div><div class='line' id='LC14'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">el</span><span class="p">.</span><span class="nx">setSelectionRange</span><span class="p">(</span><span class="nx">index</span><span class="p">,</span> <span class="nx">index</span><span class="p">);</span> </div><div class='line' id='LC15'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC16'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">};</span></div><div class='line' id='LC17'>&nbsp;&nbsp;&nbsp;&nbsp;</div><div class='line' id='LC18'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// Another behind the scenes that collects the</span></div><div class='line' id='LC19'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// current caret position for an element</span></div><div class='line' id='LC20'>&nbsp;&nbsp;&nbsp;&nbsp;</div><div class='line' id='LC21'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// TODO: Get working with Opera</span></div><div class='line' id='LC22'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">$</span><span class="p">.</span><span class="nx">caretPos</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">(</span><span class="nx">el</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC23'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">if</span> <span class="p">(</span><span class="s2">&quot;selection&quot;</span> <span class="k">in</span> <span class="nb">document</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC24'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kd">var</span> <span class="nx">range</span> <span class="o">=</span> <span class="nx">el</span><span class="p">.</span><span class="nx">createTextRange</span><span class="p">();</span></div><div class='line' id='LC25'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">try</span> <span class="p">{</span></div><div class='line' id='LC26'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">range</span><span class="p">.</span><span class="nx">setEndPoint</span><span class="p">(</span><span class="s2">&quot;EndToStart&quot;</span><span class="p">,</span> <span class="nb">document</span><span class="p">.</span><span class="nx">selection</span><span class="p">.</span><span class="nx">createRange</span><span class="p">());</span></div><div class='line' id='LC27'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span> <span class="k">catch</span> <span class="p">(</span><span class="nx">e</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC28'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// Catch IE failure here, return 0 like</span></div><div class='line' id='LC29'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// other browsers</span></div><div class='line' id='LC30'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">return</span> <span class="mi">0</span><span class="p">;</span></div><div class='line' id='LC31'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC32'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">return</span> <span class="nx">range</span><span class="p">.</span><span class="nx">text</span><span class="p">.</span><span class="nx">length</span><span class="p">;</span></div><div class='line' id='LC33'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="nx">el</span><span class="p">.</span><span class="nx">selectionStart</span> <span class="o">!=</span> <span class="kc">null</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC34'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">return</span> <span class="nx">el</span><span class="p">.</span><span class="nx">selectionStart</span><span class="p">;</span></div><div class='line' id='LC35'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC36'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">};</span></div><div class='line' id='LC37'><br/></div><div class='line' id='LC38'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// The following methods are queued under fx for more</span></div><div class='line' id='LC39'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// flexibility when combining with $.fn.delay() and</span></div><div class='line' id='LC40'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// jQuery effects.</span></div><div class='line' id='LC41'><br/></div><div class='line' id='LC42'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// Set caret to a particular index</span></div><div class='line' id='LC43'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">caret</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">(</span><span class="nx">index</span><span class="p">,</span> <span class="nx">offset</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC44'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">if</span> <span class="p">(</span><span class="k">typeof</span><span class="p">(</span><span class="nx">index</span><span class="p">)</span> <span class="o">===</span> <span class="s2">&quot;undefined&quot;</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC45'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">return</span> <span class="nx">$</span><span class="p">.</span><span class="nx">caretPos</span><span class="p">(</span><span class="k">this</span><span class="p">.</span><span class="nx">get</span><span class="p">(</span><span class="mi">0</span><span class="p">));</span></div><div class='line' id='LC46'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC47'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div class='line' id='LC48'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">return</span> <span class="k">this</span><span class="p">.</span><span class="nx">queue</span><span class="p">(</span><span class="kd">function</span> <span class="p">(</span><span class="nx">next</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC49'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">if</span> <span class="p">(</span><span class="nb">isNaN</span><span class="p">(</span><span class="nx">index</span><span class="p">))</span> <span class="p">{</span></div><div class='line' id='LC50'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kd">var</span> <span class="nx">i</span> <span class="o">=</span> <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">).</span><span class="nx">val</span><span class="p">().</span><span class="nx">indexOf</span><span class="p">(</span><span class="nx">index</span><span class="p">);</span></div><div class='line' id='LC51'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div class='line' id='LC52'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">if</span> <span class="p">(</span><span class="nx">offset</span> <span class="o">===</span> <span class="kc">true</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC53'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">i</span> <span class="o">+=</span> <span class="nx">index</span><span class="p">.</span><span class="nx">length</span><span class="p">;</span></div><div class='line' id='LC54'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span> <span class="k">else</span> <span class="k">if</span> <span class="p">(</span><span class="k">typeof</span><span class="p">(</span><span class="nx">offset</span><span class="p">)</span> <span class="o">!==</span> <span class="s2">&quot;undefined&quot;</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC55'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">i</span> <span class="o">+=</span> <span class="nx">offset</span><span class="p">;</span></div><div class='line' id='LC56'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC57'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div class='line' id='LC58'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">$</span><span class="p">.</span><span class="nx">caretTo</span><span class="p">(</span><span class="k">this</span><span class="p">,</span> <span class="nx">i</span><span class="p">);</span></div><div class='line' id='LC59'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span> <span class="k">else</span> <span class="p">{</span></div><div class='line' id='LC60'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">$</span><span class="p">.</span><span class="nx">caretTo</span><span class="p">(</span><span class="k">this</span><span class="p">,</span> <span class="nx">index</span><span class="p">);</span></div><div class='line' id='LC61'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC62'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div class='line' id='LC63'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">next</span><span class="p">();</span></div><div class='line' id='LC64'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">});</span></div><div class='line' id='LC65'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">};</span></div><div class='line' id='LC66'><br/></div><div class='line' id='LC67'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// Set caret to beginning of an element</span></div><div class='line' id='LC68'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">caretToStart</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC69'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">return</span> <span class="k">this</span><span class="p">.</span><span class="nx">caret</span><span class="p">(</span><span class="mi">0</span><span class="p">);</span></div><div class='line' id='LC70'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">};</span></div><div class='line' id='LC71'><br/></div><div class='line' id='LC72'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// Set caret to the end of an element</span></div><div class='line' id='LC73'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">$</span><span class="p">.</span><span class="nx">fn</span><span class="p">.</span><span class="nx">caretToEnd</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">()</span> <span class="p">{</span></div><div class='line' id='LC74'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">return</span> <span class="k">this</span><span class="p">.</span><span class="nx">queue</span><span class="p">(</span><span class="kd">function</span> <span class="p">(</span><span class="nx">next</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC75'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">$</span><span class="p">.</span><span class="nx">caretTo</span><span class="p">(</span><span class="k">this</span><span class="p">,</span> <span class="nx">$</span><span class="p">(</span><span class="k">this</span><span class="p">).</span><span class="nx">val</span><span class="p">().</span><span class="nx">length</span><span class="p">);</span></div><div class='line' id='LC76'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">next</span><span class="p">();</span></div><div class='line' id='LC77'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">});</span></div><div class='line' id='LC78'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">};</span></div><div class='line' id='LC79'><span class="p">}(</span><span class="nx">jQuery</span><span class="p">));</span></div></pre></div>
          </td>
        </tr>
      </table>
  </div>

          </div>
        </div>

        <a href="#jump-to-line" rel="facebox[.linejump]" data-hotkey="l" class="js-jump-to-line" style="display:none">Jump to Line</a>
        <div id="jump-to-line" style="display:none">
          <form accept-charset="UTF-8" class="js-jump-to-line-form">
            <input class="linejump-input js-jump-to-line-field" type="text" placeholder="Jump to line&hellip;">
            <button type="submit" class="button">Go</button>
          </form>
        </div>

      </div>
    </div>
</div>

<div id="js-frame-loading-template" class="frame frame-loading large-loading-area" style="display:none;">
  <img class="js-frame-loading-spinner" src="https://a248.e.akamai.net/assets.github.com/images/spinners/octocat-spinner-128.gif" height="64" width="64">
</div>


        </div>
      </div>
      <div class="modal-backdrop"></div>
    </div>

      <div id="footer-push"></div><!-- hack for sticky footer -->
    </div><!-- end of wrapper - hack for sticky footer -->

      <!-- footer -->
      <div id="footer">
  <div class="container clearfix">

      <dl class="footer_nav">
        <dt>GitHub</dt>
        <dd><a href="/about">About us</a></dd>
        <dd><a href="/blog">Blog</a></dd>
        <dd><a href="/contact">Contact &amp; support</a></dd>
        <dd><a href="http://enterprise.github.com/">GitHub Enterprise</a></dd>
        <dd><a href="http://status.github.com/">Site status</a></dd>
      </dl>

      <dl class="footer_nav">
        <dt>Applications</dt>
        <dd><a href="http://mac.github.com/">GitHub for Mac</a></dd>
        <dd><a href="http://windows.github.com/">GitHub for Windows</a></dd>
        <dd><a href="http://eclipse.github.com/">GitHub for Eclipse</a></dd>
        <dd><a href="http://mobile.github.com/">GitHub mobile apps</a></dd>
      </dl>

      <dl class="footer_nav">
        <dt>Services</dt>
        <dd><a href="http://get.gaug.es/">Gauges: Web analytics</a></dd>
        <dd><a href="http://speakerdeck.com">Speaker Deck: Presentations</a></dd>
        <dd><a href="https://gist.github.com">Gist: Code snippets</a></dd>
        <dd><a href="http://jobs.github.com/">Job board</a></dd>
      </dl>

      <dl class="footer_nav">
        <dt>Documentation</dt>
        <dd><a href="http://help.github.com/">GitHub Help</a></dd>
        <dd><a href="http://developer.github.com/">Developer API</a></dd>
        <dd><a href="http://github.github.com/github-flavored-markdown/">GitHub Flavored Markdown</a></dd>
        <dd><a href="http://pages.github.com/">GitHub Pages</a></dd>
      </dl>

      <dl class="footer_nav">
        <dt>More</dt>
        <dd><a href="http://training.github.com/">Training</a></dd>
        <dd><a href="/edu">Students &amp; teachers</a></dd>
        <dd><a href="http://shop.github.com">The Shop</a></dd>
        <dd><a href="/plans">Plans &amp; pricing</a></dd>
        <dd><a href="http://octodex.github.com/">The Octodex</a></dd>
      </dl>

      <hr class="footer-divider">


    <p class="right">&copy; 2013 <span title="0.10371s from fe3.rs.github.com">GitHub</span>, Inc. All rights reserved.</p>
    <a class="left" href="/">
      <span class="mega-octicon octicon-mark-github"></span>
    </a>
    <ul id="legal">
        <li><a href="/site/terms">Terms of Service</a></li>
        <li><a href="/site/privacy">Privacy</a></li>
        <li><a href="/security">Security</a></li>
    </ul>

  </div><!-- /.container -->

</div><!-- /.#footer -->


    <div class="fullscreen-overlay js-fullscreen-overlay" id="fullscreen_overlay">
  <div class="fullscreen-container js-fullscreen-container">
    <div class="textarea-wrap">
      <textarea name="fullscreen-contents" id="fullscreen-contents" class="js-fullscreen-contents" placeholder="" data-suggester="fullscreen_suggester"></textarea>
          <div class="suggester-container">
              <div class="suggester fullscreen-suggester js-navigation-container" id="fullscreen_suggester"
                 data-url="/DrPheltRight/jquery-caret/suggestions/commit">
              </div>
          </div>
    </div>
  </div>
  <div class="fullscreen-sidebar">
    <a href="#" class="exit-fullscreen js-exit-fullscreen tooltipped leftwards" title="Exit Zen Mode">
      <span class="mega-octicon octicon-screen-normal"></span>
    </a>
    <a href="#" class="theme-switcher js-theme-switcher tooltipped leftwards"
      title="Switch themes">
      <span class="octicon octicon-color-mode"></span>
    </a>
  </div>
</div>



    <div id="ajax-error-message" class="flash flash-error">
      <span class="octicon octicon-alert"></span>
      <a href="#" class="octicon octicon-remove-close close ajax-error-dismiss"></a>
      Something went wrong with that request. Please try again.
    </div>

    
    <span id='server_response_time' data-time='0.10477' data-host='fe3'></span>
    
  </body>
</html>

