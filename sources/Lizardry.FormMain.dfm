object FormMain: TFormMain
  Left = 0
  Top = 0
  Caption = 'Lizardry'
  ClientHeight = 712
  ClientWidth = 1184
  Color = clBtnFace
  Constraints.MinHeight = 750
  Constraints.MinWidth = 1200
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  WindowState = wsMaximized
  OnCreate = FormCreate
  OnResize = FormResize
  OnShow = FormShow
  PixelsPerInch = 96
  TextHeight = 13
  inline FrameLogin: TFrameLogin
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 0
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 712
      inherited CurrentClientVersion: TLabel
        Top = 695
        ExplicitTop = 695
      end
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 712
      ExplicitWidth = 934
      ExplicitHeight = 712
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 734
          ExplicitHeight = 487
        end
      end
      inherited Panel4: TPanel
        Width = 924
        Height = 487
        ExplicitWidth = 924
        ExplicitHeight = 487
        inherited Label3: TLabel
          Width = 924
        end
        inherited Panel5: TPanel
          Width = 924
          ExplicitWidth = 924
        end
        inherited StaticText1: TStaticText
          Width = 924
          Height = 445
          ExplicitWidth = 924
          ExplicitHeight = 445
        end
      end
      inherited Panel6: TPanel
        Height = 487
        ExplicitHeight = 487
      end
    end
  end
  inline FrameRegistration: TFrameRegistration
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 1
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 712
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 712
      ExplicitWidth = 934
      ExplicitHeight = 712
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 734
          ExplicitHeight = 487
        end
      end
      inherited Panel4: TPanel
        Width = 934
        Height = 487
        ExplicitWidth = 934
        ExplicitHeight = 487
      end
    end
  end
  inline FrameTown: TFrameTown
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    Font.Charset = RUSSIAN_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'Courier New'
    Font.Style = []
    ParentFont = False
    TabOrder = 2
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited RightPanel: TPanel
      Left = 904
      Height = 712
      ExplicitLeft = 904
      ExplicitHeight = 712
    end
    inherited LeftPanel: TPanel
      Height = 712
      ExplicitHeight = 712
    end
    inherited MainPanel: TPanel
      Width = 604
      Height = 712
      ExplicitWidth = 604
      ExplicitHeight = 712
      inherited FrameChar: TFrameChar
        Width = 604
        Height = 487
        ExplicitWidth = 604
        ExplicitHeight = 487
        inherited PageControl1: TPageControl
          Width = 604
          Height = 487
          ExplicitWidth = 604
          ExplicitHeight = 487
          inherited TabSheet2: TTabSheet
            ExplicitWidth = 596
            ExplicitHeight = 451
            inherited SG: TStringGrid
              Width = 596
              Height = 362
              ExplicitWidth = 596
              ExplicitHeight = 362
            end
            inherited Panel1: TPanel
              Width = 596
              ExplicitWidth = 596
            end
            inherited Panel2: TPanel
              Top = 387
              Width = 596
              ExplicitTop = 387
              ExplicitWidth = 596
              inherited ttInfo: TLabel
                Width = 594
                ExplicitWidth = 614
              end
            end
          end
        end
      end
      inherited FrameChat: TFrameChat
        Width = 604
        Height = 487
        ExplicitWidth = 604
        ExplicitHeight = 487
        inherited Panel1: TPanel
          Top = 455
          Width = 604
          ExplicitTop = 455
          ExplicitWidth = 604
          inherited edChatMsg: TEdit
            Width = 602
            ExplicitWidth = 602
          end
        end
        inherited Panel2: TPanel
          Width = 604
          Height = 455
          ExplicitWidth = 604
          ExplicitHeight = 455
          inherited RichEdit1: TRichEdit
            Width = 602
            Height = 453
            ExplicitWidth = 602
            ExplicitHeight = 453
          end
        end
      end
      inherited Panel10: TPanel
        Width = 604
        ExplicitWidth = 604
        inherited bbChat: TSpeedButton
          Left = 515
          ExplicitLeft = 535
        end
      end
      inherited FramePanel: TPanel
        Top = 512
        Width = 604
        ExplicitTop = 512
        ExplicitWidth = 604
        inherited FrameBank1: TFrameBank
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameDefault1: TFrameDefault
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameTavern1: TFrameTavern
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameOutlands1: TFrameOutlands
          Width = 602
          ExplicitWidth = 602
        end
        inherited FrameLoot1: TFrameLoot
          Width = 602
          ExplicitWidth = 602
        end
      end
      inherited Panel19: TPanel
        Width = 604
        Height = 487
        ExplicitWidth = 604
        ExplicitHeight = 487
        inherited FrameShop1: TFrameShop
          Width = 602
          Height = 485
          ExplicitWidth = 602
          ExplicitHeight = 485
          inherited SG: TStringGrid
            Width = 602
            ExplicitWidth = 602
          end
          inherited Panel1: TPanel
            Width = 602
            ExplicitWidth = 602
            inherited Label1: TLabel
              Width = 602
              ExplicitWidth = 622
            end
          end
          inherited Panel2: TPanel
            Width = 602
          end
        end
        inherited FrameInfo1: TFrameInfo
          Width = 602
          Height = 485
          ExplicitWidth = 602
          ExplicitHeight = 485
          inherited StaticText2: TStaticText
            Top = 351
            Width = 602
            ExplicitTop = 351
            ExplicitWidth = 602
          end
          inherited StaticText1: TStaticText
            Width = 602
            Height = 351
            ExplicitWidth = 602
            ExplicitHeight = 351
          end
        end
        inherited FrameBattle1: TFrameBattle
          Width = 602
          Height = 485
          ExplicitWidth = 602
          ExplicitHeight = 485
          inherited Panel1: TPanel
            Width = 602
            Height = 348
            ExplicitWidth = 602
            ExplicitHeight = 348
            inherited BattleLog: TRichEdit
              Width = 600
              Height = 346
              ExplicitWidth = 600
              ExplicitHeight = 346
            end
          end
          inherited Panel2: TPanel
            Width = 602
            ExplicitWidth = 602
            inherited Panel3: TPanel
              Left = 264
              ExplicitLeft = 264
            end
          end
        end
      end
    end
  end
  inline FrameUpdate: TFrameUpdate
    Left = 0
    Top = 0
    Width = 1184
    Height = 712
    Align = alClient
    TabOrder = 3
    ExplicitWidth = 1184
    ExplicitHeight = 712
    inherited Panel1: TPanel
      Height = 712
      ExplicitHeight = 712
    end
    inherited Panel2: TPanel
      Width = 934
      Height = 712
      ExplicitLeft = 250
      ExplicitTop = 0
      ExplicitWidth = 934
      ExplicitHeight = 712
      inherited ttInfo: TLabel
        Width = 934
      end
      inherited ttUpdate: TLabel
        Width = 934
      end
      inherited Panel3: TPanel
        Width = 934
        ExplicitWidth = 934
        inherited Image1: TImage
          Width = 934
          ExplicitWidth = 932
        end
      end
    end
  end
end
