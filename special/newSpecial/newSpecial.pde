int count = 100;     //default 75
int maxSize = 100;
int minSize = 20;
float[][] e = new float[count][5];
float ds=2;
boolean dragging=false;
int lockedCircle; 
int lockedOffsetX;
int lockedOffsetY;

void mousePressed () {

  for (int j=0;j< count;j++) {
    if (sq(e[j][0] - mouseX) + sq(e[j][1] - mouseY) < sq(e[j][2]/2)) {
      lockedCircle = j;
      lockedOffsetX = mouseX - (int)e[j][0];
      lockedOffsetY = mouseY - (int)e[j][1];
      dragging = true;
      break;
    }
  }
}

void mouseReleased() {
  dragging=false;
}


void setup() {

  frameRate(60);
  size(1024, 768);
  strokeWeight(1);

  for (int j=0;j< count;j++) {
    e[j][0]=random(width); // X 
    e[j][1]=random(height); // Y
    e[j][2]=random(minSize, maxSize); // Radius        
    e[j][3]=random(-.6, .6); // X Speed
    e[j][4]=random(-.6, .6); // Y Speed
  }
}


void draw() {

  background(0,0,0);

  for (int j=0;j< count;j++) {
    noStroke();
    float radi=e[j][2];
    float diam=radi/2;

    if (sq(e[j][0] - mouseX) + sq(e[j][1] - mouseY) < sq(e[j][2]/2))
      fill(240, 240, 240, 100); // green if mouseover
    else
      fill(e[j][0],e[j][1],e[j][2],100); // regular
    if ((lockedCircle == j && dragging)) {
      e[j][0]=mouseX-lockedOffsetX;
      e[j][1]=mouseY-lockedOffsetY;
    }

    ellipse(e[j][0], e[j][1], radi, radi);
    e[j][0]+=e[j][3];
    e[j][1]+=e[j][4];

    if ( e[j][0] < -diam      ) { 
      e[j][0] = width+diam;
    } 
    if ( e[j][0] > width+diam ) { 
      e[j][0] = -diam;
    }
    if ( e[j][1] < 0-diam     ) { 
      e[j][1] = height+diam;
    }
    if ( e[j][1] > height+diam) { 
      e[j][1] = -diam;
    }

    if ((lockedCircle == j && dragging)) {
      fill(255, 255, 255, 255);
      stroke(0,0,0,255);
    } 
    else {            
      fill(0, 0, 0, 255);
      stroke(255,255,255,255);
    }
    for (int k=0;k< count;k++) {
      if ( sq(e[j][0] - e[k][0]) + sq(e[j][1] - e[k][1]) < sq(diam) ) {
        line(e[j][0], e[j][1], e[k][0], e[k][1]);
      }
    }
    noStroke();      
    rect(e[j][0]-ds, e[j][1]-ds, ds*2, ds*2);
  }
}
