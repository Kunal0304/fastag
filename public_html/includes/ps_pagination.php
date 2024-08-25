<?php
/**
 * PHPSense Pagination Class
 *
 * PHP tutorials and scripts
 *
 * @package		PHPSense
 * @author		Jatinder Singh Thind
 * @copyright	Copyright (c) 2006, Jatinder Singh Thind
 * @link		http://www.phpsense.com
 */

// ------------------------------------------------------------------------


class PS_Pagination {
	var $php_self;
	var $rows_per_page = 2; //Number of records to display per page
	var $total_rows = 0; //Total number of rows returned by the query
	var $links_per_page = 5; //Number of links to display per page
	var $append = ""; //Paremeters to append to pagination links
	var $sql = "";
	var $debug = false;
	var $conn = false;
	var $page_no = 1;
	var $max_pages = 0;
	var $offset = 0;
	/**
	 * Constructor
	 *
	 * @param resource $connection Mysql connection link
	 * @param string $sql SQL query to paginate. Example : SELECT * FROM users
	 * @param integer $rows_per_page Number of records to display per page. Defaults to 10
	 * @param integer $links_per_page Number of links to display per page. Defaults to 5
	 * @param string $append Parameters to be appended to pagination links 
	 */

	
	function PS_Pagination($connection, $sql, $rows_per_page = 10, $links_per_page = 5, $append = "") {
	
		$this->conn = $connection;
		$this->sql = $sql;
		$this->rows_per_page = (int)$rows_per_page;
		if (intval($links_per_page ) > 0) {
			$this->links_per_page = (int)$links_per_page;
		} else {
			$this->links_per_page = 5;
		}
		$this->append = $append;		
		$this->php_self = htmlspecialchars($_SERVER['PHP_SELF'] );
		if (isset($_GET['page_no'] )) {
			$this->page_no = intval($_GET['page_no'] );
		}
	}
	
	/**
	 * Executes the SQL query and initializes internal variables
	 *
	 * @access public
	 * @return resource
	 */
	function paginate() {
		//Check for valid mysql connection
		if (! $this->conn || ! is_resource($this->conn )) {
			if ($this->debug)
				echo "MySQL connection missing<br />";
			return false;
		}
		
		//Find total number of rows
		$all_rs = @mysqli_query($this->sql );
		if (! $all_rs) {
			if ($this->debug)
				echo "SQL query failed. Check your query.<br /><br />Error Returned: " . mysqli_error();
			return false;
		}
		$this->total_rows = mysqli_num_rows($all_rs );
		@mysqli_close($all_rs );
		
		//Return FALSE if no rows found
		/*if ($this->total_rows == 0) {
			if ($this->debug)
				echo "No Record Found.";
			return FALSE;
		}*/
		
		//Max number of pages
		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );
		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}
		
		//Check the page value just in case someone is trying to input an aribitrary value
		if ($this->page_no > $this->max_pages || $this->page_no <= 0) {
			$this->page_no = 1;
		}
		
		//Calculate Offset
		$this->offset = $this->rows_per_page * ($this->page_no - 1);
		
		//Fetch the required result set
		$rs = @mysqli_query($this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}" );
		if (! $rs) {
			if ($this->debug)
				echo "Pagination query failed. Check your query.<br /><br />Error Returned: " . mysqli_error();
			return false;
		}
		return $rs;
	}
	
	/**
	 * Display the link to the first page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'
	 * @return string
	 */
	function renderFirst($tag = 'First') {
//print_r($_GET);
$pagemodule = $_GET['module'];
$pagename = $_GET['page'];
		
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page_no == 1) {
			return "<a href='#'> $tag </a> ";
		} else {
			return '<a href="' . $this->php_self . '?'.$this->append.'&page='.$pagename. '&page_no=1' . '">' . $tag . '</a> ';
		}
	}
	
	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
	function renderLast($tag = 'Last') {
//print_r($_GET);

$pagemodule = $_GET['module'];
$pagename = $_GET['page'];

		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page_no == $this->max_pages) {
			return "<a href='#'> $tag </a> ";
		} else {
			return ' <a href="' . $this->php_self . '?'.$this->append .'&page='.$pagename.'&page_no=' . $this->max_pages .'">' . $tag . '</a>';
		}
	}
	
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
	function renderNext($tag = '&gt;&gt;') {
$pagemodule = $_GET['module'];
$pagename = $_GET['page'];
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page_no < $this->max_pages) {
			return '<a href="' . $this->php_self  . '?'.$this->append.'&page='.$pagename.'&page_no=' . ($this->page_no + 1) . '">' . $tag . '</a>';
		} else {
			return "<a href='#'> $tag </a> ";
		}
	}
	
	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	function renderPrev($tag = '&lt;&lt;') {
$pagemodule = $_GET['module'];
$pagename = $_GET['page'];
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page_no > 1) {
			return ' <a href="' . $this->php_self  . '?'.$this->append.'&page='.$pagename.'&page_no=' . ($this->page_no - 1) .'">' . $tag . '</a>';
		} else {
			return "<a href='#'> $tag </a> ";
		}
	}
	
	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	function renderNav($prefix = '<span class="page_link">', $suffix = '</span>') {
	
$pagemodule = $_GET['module'];
$pagename = $_GET['page'];
		if ($this->total_rows == 0)
			return FALSE;
		
		$batch = ceil($this->page_no / $this->links_per_page );
		$end = $batch * $this->links_per_page;
		if ($end == $this->page_no) {
			//$end = $end + $this->links_per_page - 1;
		//$end = $end + ceil($this->links_per_page/2);
		}
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';
		
		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page_no) {
				$links .= "<span class='activ'>" . "<a href='#' class=''> $i</a> " . $suffix;
			} else {
				$links .= ' ' . $prefix . '<a href="' . $this->php_self . '?'.$this->append.'&page='.$pagename. '&page_no=' . $i . '">' . $i . '</a>' . $suffix . ' ';
			}
		}
		
		return $links;
	}
	
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	function renderFullNav() {

	      if($this->total_rows > $this->rows_per_page )
		return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();
	}
	
	/**
	 * Set debug mode
	 *
	 * @access public
	 * @param bool $debug Set to TRUE to enable debug messages
	 * @return void
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}
}


class PS_Pagination_projlist {
	var $php_self;
	var $rows_per_page = 10; //Number of records to display per page
	var $total_rows = 0; //Total number of rows returned by the query
	var $links_per_page = 5; //Number of links to display per page
	var $append = ""; //Paremeters to append to pagination links
	var $sql = "";
	var $debug = false;
	var $conn = false;
	var $page_no = 1;
	var $max_pages = 0;
	var $offset = 0;
	/**
	 * Constructor
	 *
	 * @param resource $connection Mysql connection link
	 * @param string $sql SQL query to paginate. Example : SELECT * FROM users
	 * @param integer $rows_per_page Number of records to display per page. Defaults to 10
	 * @param integer $links_per_page Number of links to display per page. Defaults to 5
	 * @param string $append Parameters to be appended to pagination links 
	 */

	
	function PS_Pagination_projlist($connection, $sql, $rows_per_page = 10, $links_per_page = 5, $append = "") {
		$this->conn = $connection;
		$this->sql = $sql;
		$this->rows_per_page = (int)$rows_per_page;
		if (intval($links_per_page ) > 0) {
			$this->links_per_page = (int)$links_per_page;
		} else {
			$this->links_per_page = 5;
		}
		$this->append = $append;
		$this->php_self = htmlspecialchars($_SERVER['PHP_SELF'] );
		if (isset($_GET['page_no'] )) {
			$this->page_no = intval($_GET['page_no'] );
		}
	}
	
	/**
	 * Executes the SQL query and initializes internal variables
	 *
	 * @access public
	 * @return resource
	 */
	function paginate() {
		//Check for valid mysql connection
		if (! $this->conn || ! is_resource($this->conn )) {
			if ($this->debug)
				echo "MySQL connection missing<br />";
			return false;
		}
		
		//Find total number of rows
		$all_rs = @mysqli_query($this->sql );
		if (! $all_rs) {
			if ($this->debug)
				echo "SQL query failed. Check your query.<br /><br />Error Returned: " . mysqli_error();
			return false;
		}
		$this->total_rows = mysqli_num_rows($all_rs );
		@mysqli_close($all_rs );
		
		//Return FALSE if no rows found
		/*if ($this->total_rows == 0) {
			if ($this->debug)
				echo "No Record Found.";
			return FALSE;
		}*/
		
		//Max number of pages
		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );
		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}
		
		//Check the page value just in case someone is trying to input an aribitrary value
		if ($this->page_no > $this->max_pages || $this->page_no <= 0) {
			$this->page_no = 1;
		}
		
		//Calculate Offset
		$this->offset = $this->rows_per_page * ($this->page_no - 1);
		
		//Fetch the required result set
		$rs = @mysqli_query($this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}" );
		if (! $rs) {
			if ($this->debug)
				echo "Pagination query failed. Check your query.<br /><br />Error Returned: " . mysqli_error();
			return false;
		}
		return $rs;
	}
	
	/**
	 * Display the link to the first page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'
	 * @return string
	 */
	function renderFirst($tag = 'First') {
//print_r($_GET);
	$id = $_GET['id'];
		
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page_no == 1) {
			return "<a herf='#' style='cursor:text'>". "$tag ". "</a>";
		} else {
			return '<a href="' . $this->php_self .'?id='.$id.'&page_no=1' . '">' . $tag . '</a> ';
		}
	}
	
	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
	function renderLast($tag = 'Last') {
//print_r($_GET);
$id = $_GET['id'];

		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page_no == $this->max_pages) {
			return "<a herf='#' style='cursor:text'>".$tag . "</a>";
		} else {
			return '<a href="' . $this->php_self .'?id='.$id.'&page_no=' . $this->max_pages .'">' . $tag . '</a>';
		}
	}
	
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string	 */

	function renderNext($tag = 'Next <b style="font-size:9px;">&gt;&gt;</b>') {
$id = $_GET['id'];
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page_no < $this->max_pages) {
			return '<a href="' . $this->php_self .'?id='.$id.'&page_no=' . ($this->page_no + 1) . '">' . $tag . '</a>';
		} else {
			return "<a herf='#' style='cursor:text'>".$tag . "</a>";
		}
	}
	
	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	function renderPrev($tag = 'Previous <b style="font-size:9px;">&lt;&lt;</b>') {
$id = $_GET['id'];
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page_no > 1) {
			return ' <a href="' . $this->php_self .'?id='.$id.'&page_no=' . ($this->page_no - 1) .'">' . $tag . '</a>';
		} else {
			return "<a herf='#' style='cursor:text'>". "$tag" ."</a>";
		}
	}
	
	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	function renderNav($prefix = '<span>', $suffix = '</span>') {
$id = $_GET['id'];
		if ($this->total_rows == 0)
			return FALSE;
		
		$batch = ceil($this->page_no / $this->links_per_page );
		$end = $batch * $this->links_per_page;
		if ($end == $this->page_no) {
			//$end = $end + $this->links_per_page - 1;
		//$end = $end + ceil($this->links_per_page/2);
		}
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';
		
		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page_no) {
				$links .=  "<span class='activ'><a href='#' style='cursor:text;'>" ." $i ". "</a></span>";
			} else {
				//$links .= ' ' . $prefix . '<a href="' . $this->php_self .'?id='.$id.'&page_no=' . $i . '">' . $i . '</a>' . $suffix . ' ';
				$links .= '<a href="' . $this->php_self .'?id='.$id.'&page_no='. $i . '">' . $i . '</a>';
			}
		}
		
		return $links;
	}
	
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	function renderFullNav() {
//		return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();

           if($this->total_rows > $this->rows_per_page )
		return $this->renderFirst() . $this->renderPrev() . $this->renderNav() . $this->renderNext() . $this->renderLast();
	}
	
	/**
	 * Set debug mode
	 *
	 * @access public
	 * @param bool $debug Set to TRUE to enable debug messages
	 * @return void
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}
}

?>
